<?php

namespace Settings\Form;

use Zend\Form\Form;

class FilterByYearForm extends Form {

    /**
     * @var string selected year to filter by 
     */
    public $selectedYear;
    protected $query;

    public function __construct($name = null, $options = null) {
        if (!(isset($options["year"]))) {
            $options["year"] = null;
        }
        $this->selectedYear = $options["year"];

        $this->query = $options['query'];
        unset($options['query']);
        parent::__construct($name, $options);

        $this->setAttribute('class', 'form form-horizontal');


        $this->add(array(
            'name' => 'year',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Year: ',
            ),
        ));

        $allHolidays = $this->query->findBy('Attendance\Entity\Holiday', array(), array('dateFrom' => 'DESC'));
        foreach ($allHolidays as $holiday) {
            $holidayYear = date_format($holiday->dateFrom, 'Y');
            $valueOptions[$holidayYear] = $holidayYear;
        }
        $year = $this->get(/* $elementOrFieldset = */ 'year');
        $year->setValueOptions($valueOptions);
        if (!is_null($this->selectedYear)) {
            $year->setValue($this->selectedYear);
        }

        $this->add(array(
            'name' => 'Filter',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Filter!',
            ),
            'options' => array(
                'label' => 'Filter!',
            ),
        ));
    }

}
