<?php
/**
 * @file Rate.php
 * @project VRPConnector
 * @author Josh Houghtelin <josh@findsomehelp.com>
 * @created 3/17/15 3:18 PM
 */

namespace Gueststream\Property;


class Rate {
    protected $startDate;
    protected $endDate;
    protected $amount;
    protected $chargeBasis;

    public function __construct($data)
    {
        foreach($data as $key => $val) {
            $setter = "set".ucfirst($key);
            if(method_exists($this,$setter)) {
                $this->$setter($val);
            }
        }
    }

    public function __get($name)
    {
        if(isset($this->$name)) {
            return $this->$name;
        }
    }

    public function __set($name, $value)
    {
        $setter = "set".ucfirst($name);
        if(method_exists($this,$setter)) {
            return $this->$setter($value);
        }
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getChargeBasis()
    {
        return $this->chargeBasis;
    }

    /**
     * @param mixed $chargeBasis
     */
    public function setChargeBasis($chargeBasis)
    {
        $this->chargeBasis = $chargeBasis;
    }


}