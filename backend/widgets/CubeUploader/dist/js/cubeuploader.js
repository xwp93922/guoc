/**
 * Created by teavoid on 17/2/21.
 */
(function($){
    "use strict";

    var defaults = {
        max:5,
        images:[],
        uploadUrl:'',
    };

    function FileItem() {

    }

    FileItem.prototype.key = '';
    FileItem.prototype.url = '';
    FileItem.prototype.generateKey = function() {
        return new Date().getTime();
    };

    $.fn.extend({
        cubeFile: function(options) {
            var opts = $.extend(defaults, options);
            cubeUploader.container = $(this);
            cubeUploader.options = opts;
            var num = opts.images.length;
            for (var i = 0; i < num; i++) {
                var image = opts.images[i];
            }

            if (num < opts.max) {
                cubeUploader.showEmptyNode();
            }

        }
    });
    var cubeUploader = {
        container:undefined,
        options:defaults,
        fileItems:[],
        popConfirmModal: function(text, confirm) {
            var _modal = $('#cube-uploader-confirm-modal');
            if (_modal.length > 0) {
                _modal.find('cube-uploader-confirm-modal-text').html(text);
            }
            else {
                _modal = CubeUploaderHtmlBuilder.createConfirmModal(text);
                $('body').append(_modal);
            }

            $('#cube-uploader-confirm-modal').find(".cube-btn-confirm").unbind();
            $('#cube-uploader-confirm-modal').find(".cube-btn-confirm").click(function() {
                confirm();
            });
            $('#cube-uploader-confirm-modal').modal('show');
        },
        dismissConfirmModal: function() {
            $('#cube-uploader-confirm-modal').modal('hide');
        },
        popImageZoomModal: function(src) {
            var container = this.container;
            var _modal = $('#cube-uploader-zoom-modal');
            if (_modal.length > 0) {
                _modal.find('img.cube-uploader-zoom-modal-image').attr('src', src);
            }
            else {
                _modal = CubeUploaderHtmlBuilder.createImageZoomModal(src);
                $('body').append(_modal);
            }


            $('#cube-uploader-zoom-modal').modal('show');
        },
        dismissImageZoomModal: function() {
            $('#cube-uploader-zoom-modal').modal('hide');
        },
        showEmptyNode: function() {
            var container = this.container;
            var _node = container.find(".cube-uploader-empty-node");
            if (_node.length == 0) {
                var _html = CubeUploaderHtmlBuilder.buildEmptyNode();
                container.append(_html);
                CubeUploaderEventBinder.bindFileLoadEvent();
            }
        },
        addPreviewNode: function(key, src) {
            var container = this.container;
            var _html = CubeUploaderHtmlBuilder.createPreviewNode(key, src);
            container.find('.cube-uploader-empty-node').before(_html);
            CubeUploaderEventBinder.bindPreviewActions();
        },
        setPreviewNodeStatus: function(node, status) {

            var btnUpload = node.find('.cube-btn-preview-action-upload');
            if (status == 'wait_upload') {

                btnUpload.removeClass('btn-success');
                btnUpload.addClass('btn-warning');
                btnUpload.html('<i class="fa fa-cloud-upload"></i>');
            }
            else if (status == 'uploaded') {
                btnUpload.removeClass('btn-warning');
                btnUpload.addClass('btn-success');
                btnUpload.html('<i class="fa fa-check"></i>');
                btnUpload.attr('disabled', 'disabled');
            }
        }
    };

    var CubeUploaderHtmlBuilder = {
        buildEmptyNode: function() {
            var _nodeHmlt = '<div class="cube-uploader-empty-node"><input type="file" /><div>';
            return _nodeHmlt;
        },
        createPreviewNode :function(key, src) {
            var _node = '<div id="' +
                    'cube-uploader-preview-node-' + key
                    +
                '" data-key="' + key +
                '" class="cube-uploader-preview-node">';

            _node += '<img class="cube-uploader-preview-image" src="' + src + '" />';
            _node += this.createPreviewAction();

            _node += '</div>';
            return _node;
        },
        createPreviewAction: function() {
            var _action = '<div class="cube-uploader-preview-action">';
            _action += this.createPreviewActionButtonZoom();
            _action += this.createPreviewActionButtonEdit();
            _action += this.createPreviewActionButtonRemove();
            _action += this.createPreviewActionButtonUpload();
            _action += '</div>';
            return _action;
        },
        createPreviewActionButtonZoom: function() {
            var _button = '<div class="cube-uploader-preview-button">';
                _button += '<button type="button" class="btn btn-xs btn-default cube-btn-preview-action-zoom"><i class="fa fa-search-plus"></i></button>';
                _button += '</div>';
            return _button;
        },
        createPreviewActionButtonEdit: function() {
            var _button = '<div class="cube-uploader-preview-button">';
            _button += '<button type="button" class="btn btn-xs btn-default cube-btn-preview-action-crop"><i class="fa fa-crop"></i></button>';
            _button += '</div>';
            return _button;
        },
        createPreviewActionButtonRemove: function() {
            var _button = '<div class="cube-uploader-preview-button">';
            _button += '<button type="button" class="btn btn-xs btn-default cube-btn-preview-action-remove"><i class="fa fa-trash-o"></i></button>';
            _button += '</div>';
            return _button;
        },
        createPreviewActionButtonUpload: function() {
            var _button = '<div class="cube-uploader-preview-button cube-btn-preview-action-right">';
            _button += '<button type="button" class="btn btn-xs btn-warning cube-btn-preview-action-upload"><i class="fa fa-cloud-upload"></i></button>';
            _button += '</div>';
            return _button;
        },
        createConfirmModal: function(text) {
            var _model = '<div id="cube-uploader-confirm-modal" class="modal fade" tabindex="-1" role="dialog">';
            _model += '<div class="modal-dialog" role="document">';
            _model += '<div class="modal-content">';
            _model += '<div class="modal-header">';
            _model += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            _model += '<h4 class="modal-title">提示</h4>';
            _model += '</div>'; //modal-header
            _model += '<div class="modal-body">';
            _model += '<p class="cube-uploader-confirm-modal-text">';
            _model += text;
            _model += '</p>';
            _model += '</div>';//modal-body
            _model += '<div class="modal-footer">';
            _model += '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>';
            _model += '<button type="button" class="btn btn-danger cube-btn-confirm">确认删除</button>';
            _model += '</div>'; //modal-footer
            _model += '</div>'; //modal-content
            _model += '</div>'; //modal-dialog
            _model += '</div>'; //modal

            return _model;
        },
        createImageZoomModal: function(src) {
            var _model = '<div id="cube-uploader-zoom-modal" class="modal fade" tabindex="-1" role="dialog">';
            _model += '<div class="modal-dialog modal-lg" role="document">';
            _model += '<div class="modal-content">';
            _model += '<div class="modal-header">';
            _model += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            _model += '<h4 class="modal-title">查看大图</h4>';
            _model += '</div>'; //modal-header
            _model += '<div class="modal-body">';
            _model += '<img class="cube-uploader-zoom-modal-image" src="';
            _model += src;
            _model += '" />';
            _model += '</div>';//modal-body
            _model += '<div class="modal-footer">';
            //_model += '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>';
            _model += '<button type="button" class="btn btn-danger cube-btn-confirm" data-dismiss="modal">关闭</button>';
            _model += '</div>'; //modal-footer
            _model += '</div>'; //modal-content
            _model += '</div>'; //modal-dialog
            _model += '</div>'; //modal

            return _model;
        }

    };

    var CubeUploaderEventBinder = {
        bindPreviewActions: function() {
            CubeUploaderEventBinder.bindPreviewActionRemove();
            CubeUploaderEventBinder.bindPreviewActionCrop();
            CubeUploaderEventBinder.bindPreviewActionZoom();
            CubeUploaderEventBinder.bindUploadEvent();
        },
        bindPreviewActionZoom: function() {
            $(".cube-btn-preview-action-zoom").unbind();
            $(".cube-btn-preview-action-zoom").click(function () {
                var self = this;
                var previewNode = $(self).closest('.cube-uploader-preview-node');
                var src = previewNode.find(".cube-uploader-preview-image").attr("src");
                cubeUploader.popImageZoomModal(src);
            });
        },
        bindPreviewActionCrop: function() {
            $(".cube-btn-preview-action-crop").unbind();
            $(".cube-btn-preview-action-crop").click(function () {
                var self = this;
                var previewNode = $(self).closest('.cube-uploader-preview-node');
                var src = previewNode.find(".cube-uploader-preview-image").attr("src");
                var thisImage = previewNode.find(".cube-uploader-preview-image");
                thisImage.cubeCropper({}, function(src) {
                    var oldSrc = thisImage.attr('src');
                    window.URL.revokeObjectURL(oldSrc);
                    thisImage.attr('src', src);
                    cubeUploader.setPreviewNodeStatus(previewNode, 'wait_upload');
                });
            });
        },
        bindPreviewActionRemove: function() {
            $(".cube-btn-preview-action-remove").unbind();
            $(".cube-btn-preview-action-remove").click(function () {
                var self = this;
                cubeUploader.popConfirmModal("请确认是否删除？", function() {
                    cubeUploader.dismissConfirmModal();

                    $(self).closest('.cube-uploader-preview-node').fadeOut('slow', function() {
                        $(self).closest('.cube-uploader-preview-node').remove()
                    });
                });
            });
        },
        bindFileLoadEvent: function() {
            var container = cubeUploader.container;
            container.find('.cube-uploader-empty-node').on('change', '[type=file]', function() {
                var file = this.files[0];
                //file.size
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e){
                    var src = this.result;

                    var fileItem = new FileItem();
                    fileItem.key = fileItem.generateKey();
                    cubeUploader.fileItems.push(fileItem);
                    cubeUploader.addPreviewNode(fileItem.key, src);
                }
            });
        },
        bindUploadEvent: function() {
            var uploadUrl = cubeUploader.options.uploadUrl;
            $(".cube-btn-preview-action-upload").unbind();
            $(".cube-btn-preview-action-upload").click(function () {
                var previewNode = $(this).closest('.cube-uploader-preview-node');
                var src = previewNode.find(".cube-uploader-preview-image").attr("src");
                if (src.indexOf('blob')) {

                }
                else if (src.indexOf('data:image')) {

                }
                //cubeUploader.setPreviewNodeStatus(previewNode, 'uploaded');

            });
        },

    };

})(jQuery);

$("#testcube").cubeFile();