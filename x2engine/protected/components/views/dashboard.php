<?php
/***********************************************************************************
 * X2Engine Open Source Edition is a customer relationship management program developed by
 * X2 Engine, Inc. Copyright (C) 2011-2019 X2 Engine Inc.
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
 * You can contact X2Engine, Inc. P.O. Box 610121, Redwood City,
 * California 94061, USA. or at email address contact@x2engine.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * X2 Engine" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by X2 Engine".
 **********************************************************************************/






$hiddenGraphs = $this->getHiddenGraphs ();
?>

<div class='chart-dashboard'>
    <!-- Dashboard -->
        <div class='toolbar'>
        <h2> Charts on this report
        </h2>
            <span id="minimize-dashboard" >
                <i class='fa fa-caret-down fa-lg'></i>
            </span>
            <span id="hidden-data-widgets-button" class="x2-button">
                <i class='fa fa-toggle-down'></i>
                <?php
                echo CHtml::encode (Yii::t('app', 'Hidden Charts'))   
                ?>
            </span>
            <span id="create-chart-button" class="x2-button">
                <i class='fa fa-plus'></i>
                <?php
                echo CHtml::encode (Yii::t('app', 'Create Chart'))   
                ?>
            </span>
            <span id="refresh-charts-button" class="x2-button">
                <i class='fa fa-refresh'></i>
                <?php
                echo CHtml::encode (Yii::t('app', 'Refresh Charts'))   
                ?>
            </span>
            <span id="save-chart-message" class='x2-button'>
                <?php echo Yii::t('charts', 'Save report to create a chart')?>
            </span>

            <div class='clear'></div>
        </div>

        <!-- <span id="dashboard-fullscreen-button" class="x2-button"> -->
        <!-- Fullscreen -->
        <!-- </span> -->
    <!-- </div> -->

    <div id="x2-hidden-data-widgets-menu-container" class="popup-dropdown-menu">
        <ul id="x2-hidden-data-widgets-menu" class="closed" >
        <?php 
            echo '<span class="no-hidden-data-widgets-text">'.Yii::t('charts','No Hidden Charts')."</span>";
            foreach($hiddenGraphs as $name => $widget) {
                echo "<li><span class='x2-hidden-widgets-menu-item data-widget' id='$name'>
                    $widget[label]</span></li>";
            } 
        ?>
        </ul>
    </div>

    <?php 
        if (!$this->report) {
            echo '<div id="report-list">';
            echo $this->getReportList();
            echo '</div>';
        } 
    ?>

    <div class="dashboard-inner">

    <div id='data-widgets-container' style='background: blue'>
        <div id='data-widgets-container-inner' class='connected-sortable-data-container'>

        <?php
        $this->displayWidgets (1);
        ?>
        <!-- </div> -->
        </div>
    </div>

    <div id='data-widgets-container-2' class='connected-sortable-data-container'>
        <?php
        $this->displayWidgets (2);
        ?>
    </div>

    <div class='clear'></div>
    </div>
</div>
