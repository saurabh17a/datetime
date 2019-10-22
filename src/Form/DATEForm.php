<?php

namespace Drupal\datetime\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an Form for Date and time
 */
class DATEForm extends FormBase {
    /**
     * (@inheritdoc)
     */
    public function getFormId(){
        return 'datetime_email_form';
    }
    public function buildForm(array $form, FormStateInterface $form_state){
        $form['date_field'] = [
            '#title' => t('Date and Time as per Indian Standard Timezone'),
            '#type' => 'datetime',
            '#required' => TRUE,   
        ];
        $form['timezone'] = array(
            '#title' =>t('Time Zone'),
            '#type' =>'select',
            '#options' => [
                '-10' => '(GMT-10:00) America/Adak (Hawaii-Aleutian Standard Time)',
                '-9' => '(GMT-9:00) America/Anchorage (Alaska Standard Time)',
                '+6' => '(GMT+6:00)',
                '+5' => '(GMT+5:00)',
                '+4' => '(GMT+4:00)',


            ]
        );
        
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Show'),
        );
        return $form;
    }
    /**
     * (@inheritdoc)
     */
    public function submitForm(array &$form, FormStateInterface $form_state){
        $timings = number_format($form_state->getValue('timezone'));
        $datetime = $form_state->getValue('date_field');
        $datetimeValue = (strtotime($datetime)-1571682600);
        $get_second = $datetimeValue%60;
        $get_hour = floor($datetimeValue/3600);
        $get_minutes = floor(($datetimeValue/60)-$get_hour*60);
        $timezoneValue = ($get_hour*60)-330+$get_minutes+($timings*60);
        $tzhour = ceil($timezoneValue/60)+23;
        $tzminute = ceil($timezoneValue-($tzhour*60))%60;
        $tzhour = $tzhour%24;
        $tzminute = $tzminute+60;
        drupal_set_message("If IST is ".$get_hour.":".$get_minutes." The at your selected timezone it will be ".$tzhour.":".$tzminute);
    }
}