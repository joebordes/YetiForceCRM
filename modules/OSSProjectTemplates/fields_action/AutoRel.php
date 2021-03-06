<?php
/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
require_once 'modules/OSSProjectTemplates/fields_action/Base.php';

class Field_Model_AutoRel extends Field_Model_Base {

    private $tplAddress = 'fields_tpl/autorel.tpl'; 
    
    public function process($fieldName, $moduleName) {
        $viewer = new Vtiger_Viewer();
        $viewer->assign('FLD_NAME', $fieldName);
        $viewer->assign('FLD_ID', $fieldName);
        $viewer->assign('FLD_REQUIRED', $this->fieldIsRequired($fieldName, $moduleName));
        return $viewer->view($this->tplAddress, "Settings:OSSProjectTemplates", true);
        
    }
    
    function getValue($fieldName, $relId, $templateId, $baseRecord = NULL, $parentTplId = NULL) {
        $val = parent::getValue($fieldName, $relId, $templateId, $baseRecord, $parentTplId);
        
        if ('none' === $val) {
            return '';
        }
        else if ('base_on_record' == $val) {
            if (isRecordExists($relId)) {
                $recordModel = Vtiger_Record_Model::getInstanceById($relId);
                return $recordModel->get('related_to');
            } else {
                return '';
            }
        }
        else {
            return '';
        }
    }

}
