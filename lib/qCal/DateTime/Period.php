<?php

namespace qCal\DateTime;
use qCal\DateTime\DateTime,
    qCal\DateTime\TimeZone,
    qCal\DateTime\Duration;

class Period {

    protected $_start;
    
    protected $_end;
    
    public function __construct($start, $end) {
    
        $this->setStart($start)
             ->setEnd($end);
    
    }
    
    public function setStart($start) {
    
        if (!($start instanceof DateTime)) {
            throw new \InvalidArgumentException('Start date/time must be an instance of DateTime.');
        }
        $this->_start = $start;
        return $this;
    
    }
    
    public function setEnd($end) {
    
        if (!($end instanceof DateTime) && !($end instanceof Duration)) {
            throw new \InvalidArgumentException('End date/time must be an instance of DateTime or Duration.');
        }
        $this->_end = $end;
        return $this;
    
    }
    
    public function toString($convertDuration = false) {
    
        $start = $this->_start->toString('Ymd\THis\Z', new TimeZone('UTC'));
        if ($this->_end instanceof DateTime) {
            $end = $this->_end->toString('Ymd\THis\Z', new TimeZone('UTC'));
        } elseif ($this->_end instanceof Duration) {
            if ($convertDuration) {
                $end = $this->_start->add($this->_end);
                $end = $end->toString('Ymd\THis\Z', new TimeZone('UTC'));
            } else {
                $end = $this->_end->toString();
            }
        }
        return $start . '/' . $end;
    
    }

}