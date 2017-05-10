<?php
namespace common\widgets;

use Yii;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class NewLinkPager extends \yii\widgets\LinkPager
{
    public function run(){
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $prePage = [];
        $nextPage = [];
        $cell = [
            'label' => '',
            'page' => '',
            'active' => false,
        ];

        // first page
        /**
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }
        **/

        $currentPage = $this->pagination->getPage();
        // prev page
        if (($page = $currentPage - 1) < 0) {
            $page = 0;
        }
        $prePage = [ 'page' => $page ];

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = [
                'label' => $i+1,
                'page' => $i,
                'active' => $i == $currentPage,
            ];
        }

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1) {
            $page = $pageCount - 1;
        }
        $nextPage = ['page' => $page];

        // last page
        /**
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }
        **/

        //return Html::tag('ul', implode("\n", $buttons), $this->options);
        return $this->render('NewLinkPager', [
                'pagination' => $this->pagination,
                'buttons' => $buttons,
                'prePage' => $prePage,
                'nextPage' => $nextPage,
            ]);
    }
}
