<?php

namespace Settings\Form;

use Utilities\Form\Form;

/**
 * FilterByYear Form
 * 
 * Handles FilterByYear form setup
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class FilterByYearForm extends Form {

    /**
     * @var string selected year to filter by 
     */
    public $selectedYear;
    
    /**
     *
     * @var Utilities\Service\Query\Query 
     */
    protected $query;

    /**
     * setup form
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $name ,default is null
     * @param array $options ,default is null
     */
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

        $allHolidays = $this->query->findBy('Settings\Entity\Holiday', array(), array('dateFrom' => 'DESC'));
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
            )
        ));
    }

}
