<?php

namespace Hjem\FrontpointSecurity;

use DateTime;

class HistoryEntry
{
    const DATETIME_FORMAT = 'g:i a, M-j-Y';

    private $device;
    private $event;
    private $datetime;

    public function __construct($device = null, $event = null, $datetime = null) {
        $this->device = $device;
        $this->event = $event;
        $this->datetime = $datetime;
    }

    /**
     * Gets the value of device.
     *
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Sets the value of device.
     *
     * @param string $device the device
     *
     * @return self
     */
    public function setDevice($device)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Gets the value of event.
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Sets the value of event.
     *
     * @param string $event the event
     *
     * @return self
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Gets the value of datetime.
     *
     * @return string
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Sets the value of datetime.
     *
     * @param string $datetime the datetime
     *
     * @return self
     */
    public function setDatetime($datetime)
    {
        $this->datetime = DateTime::createFromFormat(self::DATETIME_FORMAT, $datetime);

        return $this;
    }
}
