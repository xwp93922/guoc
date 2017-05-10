/**
 * Created by teavoid on 17/2/22.
 */
/*
1. 在img上调用cubeCropper 即可弹出面板
2. 面板全局共享
3. 回调函数中返回裁剪后的blob数据
 */
(function($) {
    "use strict";
    
    $.fn.extend({
        cubeCropper: function(options, callback) {
            var $this = $(this);
            var src = $this.attr('src');
            var radio = 16 / 9;
            cubeCropper.currentTarget = $this;
            cubeCropper.callback = callback;
            cubeCropper.installModal().setOriginImage(src).destroyCropper().installCropper(radio).showModal();
        }
    });

    var cubeCropper = {
        callback:undefined,
        installModal: function() {
            //判断裁剪面板是否已经存在，不存在则创建
            var cropperModal = $('#cube-crop-modal');
            if (cropperModal.length == 0) {
                var modalHtml = cubeCropperHtmlBuilder.buildImageEditModal();
                $('body').append(modalHtml);
                cubeCropperEventBinder.bindBtnActions();
            }
            return this;
        },
        setOriginImage: function(src) {
            console.log(33);
            $('img.cube-uploader-edit-modal-image').attr('src', src);
            return this;
        },
        showModal: function() {
            $('#cube-crop-modal').modal('show');
            return this;
        },
        dismissModal: function() {
            $('#cube-crop-modal').modal('hide');
            return this;
        },
        installCropper: function (ratio) {
            var target = $('.cube-uploader-edit-modal-image');
            var previewItem = $(".cube-uploader-edit-modal-image-preview");
            var previewItemHeight = previewItem.width() / ratio;
            previewItem.height(previewItemHeight);

            target.cropper({
                aspectRatio: ratio,
                dragMode:'move',
                preview:'.cube-uploader-edit-modal-image-preview',
                viewMode:0,
                crop: function(e) {
                    $("#cropWidth").val(Math.ceil(e.width));
                    $("#cropHeight").val(Math.ceil(e.height));
                }
            });
            return this;
        },
        destroyCropper: function () {
            var target = $('#cube-crop-modal').find('.cube-uploader-edit-modal-image');
            target.cropper('destroy');
            return this;
        },
    };



    var cubeCropperEventBinder = {
        bindBtnActions: function() {
            // Options
            var $image = $('.cube-uploader-edit-modal-image');

            $('.cube-btn-do-crop').click(function () {
                $image.cropper('getCroppedCanvas').toBlob(function (blob) {
                    cubeCropper.callback(window.URL.createObjectURL(blob));

                    cubeCropper.dismissModal();
                });
            });

            $('#cropWidthBox').spinner('delay', 200).spinner('changing', function(e, newVal, oldVal) {
                var data = $image.cropper('getData');
                var step = newVal - oldVal;
                data.width = data.width + step;

                $image.cropper('setData', data);
            });
            $('#cropHeightBox').spinner('delay', 200).spinner('changing', function(e, newVal, oldVal) {
                var data = $image.cropper('getData');

                var step = newVal - oldVal;
                console.log("data.height 1 " + data.height);
                data.height = data.height + step;
                console.log("data.height 122 " + data.height);
                $image.cropper('setData', data);
            });

            $('.cube-uploader-edit-modal-action-panel').on('change', 'input[name=aspectRatio]', function () {
                var ratio = $(this).val();
                cubeCropper.destroyCropper().installCropper(ratio);
            });

            $('.cube-uploader-edit-modal-action-panel').on('click', '[data-action]', function () {
                var $this = $(this);
                var data = $this.data();
                var $target;
                var result;

                if ($this.prop('disabled') || $this.hasClass('disabled')) {
                    return;
                }

                if ($image.data('cropper') && data.action) {
                    data = $.extend({}, data); // Clone a new one

                    if (typeof data.target !== 'undefined') {
                        $target = $(data.target);

                        if (typeof data.option === 'undefined') {
                            try {
                                data.option = JSON.parse($target.val());
                            } catch (e) {
                                console.log(e.message);
                            }
                        }
                    }

                    if (data.action === 'rotate') {
                        $image.cropper('clear');
                    }

                    result = $image.cropper(data.action, data.option, data.secondOption);

                    if (data.action === 'rotate') {
                        $image.cropper('crop');
                    }

                    switch (data.action) {
                        case 'scaleX':
                        case 'scaleY':
                            $(this).data('option', -data.option);
                            break;
                    }

                    if ($.isPlainObject(result) && $target) {
                        try {
                            $target.val(JSON.stringify(result));
                        } catch (e) {
                            console.log(e.message);
                        }
                    }

                }
            });

        }
    };

    var cubeCropperHtmlBuilder = {
        buildImageEditModal: function() {
            var _model = '<div id="cube-crop-modal" class="modal fade" tabindex="-1" role="dialog">';
            _model += '<div class="modal-dialog modal-full-width" role="document">';
            _model += '<div class="modal-content">';
            _model += '<div class="modal-header">';
            _model += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            _model += '<h4 class="modal-title">图片裁剪</h4>';
            _model += '</div>'; //modal-header
            _model += '<div class="modal-body">';
            _model += '<div class="modal-edit-image-container">';
            _model += '<img class="cube-uploader-edit-modal-image" src="" />';
            _model += '</div>';
            _model += '<div class="cube-uploader-edit-modal-action-panel">';
            _model += '<div class="panel panel-default"> \
                        <div class="panel-heading"> \
                            <h3 class="panel-title">裁剪区域设置</h3> \
                        </div> \
                        <div class="panel-body">';

            _model += '<div class="cube-uploader-edit-modal-info"> \
                            <div id="cropWidthBox" class="input-group input-group-sm" data-trigger="spinner"> \
                                <label class="input-group-addon" for="cropWidth">宽</label> \
                                <input readonly type="text" data-rule="quantity" class="form-control crop-input" id="cropWidth" placeholder="width"> \
                                <span class="input-group-addon"> \
                                    <a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-caret-up"></i></a> \
                                    <a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-caret-down"></i></a> \
                                </span> \
                            </div> \
                            <div id="cropHeightBox" class="input-group input-group-sm" data-trigger="spinner"> \
                                <label class="input-group-addon" for="cropHeight">高</label> \
                                <input readonly type="text" data-rule="quantity" class="form-control crop-input" id="cropHeight" placeholder="height"> \
                                <span class="input-group-addon"> \
                                    <a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-caret-up"></i></a> \
                                    <a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-caret-down"></i></a> \
                                </span> \
                            </div> \
                        </div>';

            _model += '<div class="cube-uploader-edit-modal-action-row">';
            _model += '<div class="btn-group d-flex flex-nowrap" data-toggle="buttons"> \
                        <label class="btn btn-info" aria-pressed="true"> \
                            <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777"> \
                            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="aspectRatio: 16 / 9"> \
                            16:9 \
                        </span> \
                        </label> \
                        <label class="btn btn-info" aria-pressed="true"> \
                            <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333"> \
                            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="aspectRatio: 4 / 3"> \
                            4:3 \
                        </span> \
                        </label> \
                        <label class="btn btn-info" aria-pressed="true"> \
                            <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1"> \
                            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="aspectRatio: 1 / 1"> \
                            1:1 \
                        </span> \
                        </label> \
                        <label class="btn btn-info"> \
                            <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666"> \
                            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="aspectRatio: 2 / 3"> \
                            2:3 \
                        </span> \
                        </label> \
                        <label class="btn btn-info" aria-pressed="true"> \
                            <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN"> \
                            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="aspectRatio: NaN"> \
                            Free \
                            </span> \
                        </label> \
                      </div>';
            _model += '</div>'; //cube-uploader-edit-modal-action-row
            _model += '</div> \
                        </div>'; //panel-body

            _model += '<div class="cube-uploader-edit-modal-action-row">';
            _model += '<div class="panel panel-default"> \
                        <div class="panel-heading"> \
                            <h3 class="panel-title">原图操作</h3> \
                        </div> \
                        <div class="panel-body">';
            _model += '<div class="btn-group"> \
                            <button type="button" class="btn btn-info" data-action="move" data-option="-10" data-second-option="0" title="Move Left"> \
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, -10, 0)"> \
                                    <span class="fa fa-arrow-left"></span> \
                                </span> \
                            </button> \
                            <button type="button" class="btn btn-info" data-action="move" data-option="10" data-second-option="0" title="Move Right"> \
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 10, 0)"> \
                                    <span class="fa fa-arrow-right"></span> \
                                </span> \
                            </button> \
                            <button type="button" class="btn btn-info" data-action="move" data-option="0" data-second-option="-10" title="Move Up"> \
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, -10)"> \
                                    <span class="fa fa-arrow-up"></span> \
                                </span> \
                            </button> \
                            <button type="button" class="btn btn-info" data-action="move" data-option="0" data-second-option="10" title="Move Down"> \
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, 10)"> \
                                    <span class="fa fa-arrow-down"></span> \
                                </span> \
                            </button> \
                        </div><br />';

            _model += '<div class="btn-group"> \
                            <button type="button" class="btn btn-info" data-action="zoom" data-option="0.1" title="Zoom In"> \
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="放大"> \
                                    <span class="fa fa-search-plus"></span> \
                                </span> \
                            </button> \
                            <button type="button" class="btn btn-info" data-action="zoom" data-option="-0.1" title="Zoom Out"> \
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="缩小"> \
                                    <span class="fa fa-search-minus"></span> \
                                </span> \
                            </button> \
                        </div>';

            _model += '<div class="btn-group"> \
                            <button type="button" class="btn btn-info" data-action="rotate" data-option="-90" title="Rotate Left"> \
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;rotate&quot;, -45)"> \
                                    <span class="fa fa-rotate-left"></span> \
                                </span> \
                            </button> \
                            <button type="button" class="btn btn-info" data-action="rotate" data-option="90" title="Rotate Right"> \
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;rotate&quot;, 45)"> \
                                    <span class="fa fa-rotate-right"></span> \
                                </span> \
                            </button> \
                        </div>';

            _model += '<div class="btn-group"> \
                            <button type="button" class="btn btn-warning" data-action="reset" title="Reset"> \
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;reset&quot;)"> \
                                    <span class="fa fa-refresh"></span> \
                                </span> \
                            </button> \
                        </div><br \>';

            _model += '</div> \
                        </div>'; //panel-body

            _model += '<div class="btn-group"> \
                            <button type="button" class="btn btn-success cube-btn-do-crop"> \
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""> \
                                    <span class="fa fa-crop"></span> 确认裁剪 \
                                </span> \
                            </button> \
                        </div>';

            _model += '</div>';
            _model += '</div>'; //cube-uploader-edit-modal-preivew-panel
            _model += '<div class="cube-uploader-edit-modal-preivew-panel">';
            _model += '<div class="cube-uploader-edit-modal-image-preview img-preview preview-lg"></div>';
            _model += '</div>'; //cube-uploader-edit-modal-preivew-panel

            _model += '<div class="clearfix"></div>';
            _model += '</div>';//modal-body
            _model += '<div class="modal-footer">';
            //_model += '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>';
            _model += '<button type="button" class="btn btn-danger cube-btn-confirm" data-dismiss="modal">关闭</button>';
            _model += '</div>'; //modal-footer
            _model += '</div>'; //modal-content
            _model += '</div>'; //modal-dialog
            _model += '</div>'; //modal

            return _model;
        },
    };
})(jQuery);