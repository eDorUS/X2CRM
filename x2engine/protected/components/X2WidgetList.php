<?php

/*****************************************************************************************
 * X2CRM Open Source Edition is a customer relationship management program developed by
 * X2Engine, Inc. Copyright (C) 2011-2013 X2Engine Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY X2ENGINE, X2ENGINE DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact X2Engine, Inc. P.O. Box 66752, Scotts Valley,
 * California 95067, USA. or at email address contact@x2engine.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * X2Engine" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by X2Engine".
 *****************************************************************************************/

/**
 * Class for displaying tags on a record.
 *
 * @package X2CRM.components
 */
class X2WidgetList extends X2Widget {

    public $model;
    public $modelType;
    public $block; // left, right, or center
    public $layout; // associative array with 3 lists of widgets: left, right, and center
    public $associationType;
    public $associationId;

    // widget specific javascript packages
    public static function packages () {
        $packages = array (
            'widgetListCombinedCss' => array(
                'baseUrl' => Yii::app()->request->baseUrl,
                'css' => array (
                    'js/widgetListCombined.css'
                    /*'js/gallerymanager/bootstrap/css/bootstrap.css',
                    'js/jqplot/jquery.jqplot.css',
                    'js/checklistDropdown/jquery.multiselect.css'*/
                )
            ),
            'widgetListCombinedCss2' => array(
                'baseUrl' => Yii::app()->getTheme ()->getBaseUrl (),
                'css' => array (
                    'css/widgetListCombined.css'
                    /*'css/galleryWidgetCssOverrides.css',
                    'css/x2chart.css'*/
                )
            ),
            'GalleryWidgetJS' => array(
                'baseUrl' => Yii::app()->request->baseUrl,
                'js' => array(
                    'js/galleryManagerDialogSetup.js',
                    'js/gallerymanager/bootstrap/js/bootstrap.js',
                ),
                /*'css' => array (
                    'js/gallerymanager/bootstrap/css/bootstrap.css',
                )*/
            ),
            /*'GalleryWidgetCss' => array(
                'baseUrl' => Yii::app()->getTheme ()->getBaseUrl (),
                'css' => array(
                    'css/galleryWidgetCssOverrides.css',
                )
            ),*/
            'ChartWidgetExtJS' => array(
                'baseUrl' => Yii::app()->request->baseUrl,
                'js' => array(
                    'js/jqplot/jquery.jqplot.js',
                    'js/jqplot/plugins/jqplot.pieRenderer.js',
                    'js/jqplot/plugins/jqplot.categoryAxisRenderer.js',
                    'js/jqplot/plugins/jqplot.pointLabels.js',
                    'js/jqplot/plugins/jqplot.dateAxisRenderer.js',
                    'js/jqplot/plugins/jqplot.highlighter.js',
                    'js/jqplot/plugins/jqplot.enhancedLegendRenderer.js',
                    'js/checklistDropdown/jquery.multiselect.js',
                ),
                /*'css' => array(
                    'js/jqplot/jquery.jqplot.css',
                    'js/checklistDropdown/jquery.multiselect.css'
                ),*/
            ),
            'ChartWidgetExtCss' => array(
                'baseUrl' => Yii::app()->request->baseUrl,
                'css' => array(
                    'js/jqplot/jquery.jqplot.css',
                    'js/checklistDropdown/jquery.multiselect.css'
                ),
            ),
            'ChartWidgetJS' => array(
                'baseUrl' => Yii::app()->request->baseUrl,
                'js' => array(
                    'js/auxlib.js',
                    'js/X2Chart.js',
                    'js/X2ActionHistoryChart.js',
                ),
            ),
            'ChartWidgetCss' => array(
                'baseUrl' => Yii::app()->getTheme ()->getBaseUrl (),
                'css' => array(
                    'css/x2chart.css'
                )
            ),
            'InlineRelationshipsJS' => array(
                'baseUrl' => Yii::app()->getTheme ()->getBaseUrl ().'/css/gridview/',
                'js' => array (
                    'jquery.yiigridview.js',
                )
            ),
            'InlineTagsJS' => array(
                'baseUrl' => Yii::app()->request->baseUrl,
                'js' => array(
                    'js/auxlib.js',
                    'js/X2Tags/TagContainer.js',
                    'js/X2Tags/TagCreationContainer.js',
                    'js/X2Tags/InlineTagsContainer.js',
                ),
            ),
        );
        if (AuxLib::isIE8 ()) {
            $packages['ChartWidgetExtJS']['js'][] = 'js/jqplot/excanvas.js';
        }
        return $packages;
    }


    public function init(){
        // widget layout
        if(!Yii::app()->user->isGuest){
            $this->layout = Yii::app()->params->profile->getLayout ();
        }else{
            $profile = new Profile();
            $this->layout = $profile->initLayout ();
        }

        parent::init();
    }

    public function run(){

        if($this->block == 'center'){
            echo '<div id="content-widgets">';
            foreach($this->layout['center'] as $name => $widget){ // list of widgets
                $viewParams = array(
                    'widget' => $widget,
                    'name' => $name,
                    'model' => $this->model,
                    'modelType' => $this->modelType,
                    'packagesOnly' => false
                );

                if(!$this->isExcluded ($name)){
                    $this->render(
                        'centerWidget',
                        $viewParams
                    );
                }
            }
            foreach($this->layout['hidden'] as $name => $widget){ // list of widgets
                $viewParams = array(
                    'widget' => $widget,
                    'name' => $name,
                    'model' => $this->model,
                    'modelType' => $this->modelType,
                    'packagesOnly' => true
                );
                if(!$this->isExcluded ($name)){
                    $this->render(
                        'centerWidget',
                        $viewParams
                    );
                }
            }

            echo '</div>';
        }
    }

    private function isExcluded ($name) {
        if ($this->modelType == 'BugReports' && ($name != 'InlineRelationships' && $name!='WorkflowStageDetails') ||
            $this->modelType == 'Quote' && $name == 'WorkflowStageDetails' ||
            $this->modelType == 'Marketing' &&
            ($name == 'WorkflowStageDetails' || $name === 'InlineRelationships') ||
            $this->modelType == 'services' && $name == 'InlineRelationships' ||
            $this->modelType === 'products' &&
            ($name === 'InlineRelationships' || $name === 'WorkflowStageDetails')) {
            return true;
        } else {
            return false;
        }
    }

}
