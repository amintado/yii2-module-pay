<?php
/*******************************************************************************
 * Copyright (c) 2017.
 * this file created in printing-office project
 * framework: Yii2
 * license: GPL V3 2017 - 2025
 * Author:amintado@gmail.com
 * Company:shahrmap.ir
 * Official GitHub Page: https://github.com/amintado/printing-office
 * All rights reserved.
 ******************************************************************************/

namespace amintado\pay\models\traits;

use common\config\components\functions;
use common\models\User;
use Yii;

trait GlobalTrait
{
    public function getStatusPanel()
    {

        if (!empty($this->status) or $this->status==0) {
            $status = Yii::t('common', 'Product Status -' . $this->status);
        }
        return '
            
             <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">' . Yii::t('common', 'Status') . '</h3>
                            </div>
                            <div class="panel-body">
                                ' . $status . '
                            </div>
            </div>
            
            
            
            
            ';


    }

    public function getAuthorPanel()
    {
        $author = User::findOne($this->created_by);

        $author = !empty($author) ? $author->fullname : Yii::t('common', 'unknown');

        $updater = User::findOne($this->updated_by);
        $updater = !empty($updater) ? $updater->fullname : Yii::t('common', 'unknown');

        $created_at = !empty($this->created_at) ? functions::convertdate($this->created_at) : null;
        $updated_at = !empty($this->updated_at) ? functions::convertdate($this->updated_at) : null;
        return '
            
             <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">' . Yii::t('common', 'Author Panel') . '</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        ' . Yii::t('common', 'Authorَ') . $author . '
                                    </div>
                                </div>
                                
                                 <div class="row">
                                    <div class="col-md-12">
                                        ' . Yii::t('common', 'Updater') . $updater . '
                                    </div>
                                </div>
                                
                                 <div class="row">
                                    <div class="col-md-12">
                                        ' . Yii::t('common', 'Side Created At') . $created_at . '
                                    </div>
                                </div>
                                
                                 <div class="row">
                                    <div class="col-md-12">
                                        ' . Yii::t('common', 'Side Updated At') . $updated_at . '
                                    </div>
                                </div>
                            </div>
            </div>
            
            
            
            
            ';
    }

    public function showSidePanel()
    {
        return '<div class="row">
                    <div class="col-md-12">
                       '. $this->getStatusPanel() .'
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        '. $this->getAuthorPanel().'
                    </div>
                </div>';
    }

    /**
     * this function will hash model id
     */
    public function hash()
    {
        $this->hash_id = hash('adler32', $this->id);
        $this->save();
        return;
    }
}