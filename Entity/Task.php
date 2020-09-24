<?php


class Task extends Entity
{
    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $task;

    /**
     * @var string
     */
    public $dateEnd;

    /**
     * @var string
     */
    public $region;

    /**
     * @var array
     */
    public $files = [];

    /**
     * @var string
     */
    public $priority;

    /**
     * @var string
     */
    public $responsible;

    /**
     * @var string
     */
    public $parentTask;

    /**
     * @var array
     */
    public $coExecutors = [];

    /**
     * @var string
     */
    public $tracker;

    /**
     * @var string
     */
    public $status;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTask(): string
    {
        return $this->task;
    }

    /**
     * @param string $task
     */
    public function setTask(string $task)
    {
        $this->task = $task;
    }

    /**
     * @return string
     */
    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }

    /**
     * @param string $dateEnd
     */
    public function setDateEnd(string $dateEnd)
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region)
    {
        $this->region = $region;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param array $files
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     */
    public function setPriority(string $priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getResponsible(): string
    {
        return $this->responsible;
    }

    /**
     * @param string $responsible
     */
    public function setResponsible(string $responsible)
    {
        $this->responsible = $responsible;
    }

    /**
     * @return string
     */
    public function getParentTask(): string
    {
        return $this->parentTask;
    }

    /**
     * @param string $parentTask
     */
    public function setParentTask(string $parentTask)
    {
        $this->parentTask = $parentTask;
    }

    /**
     * @return array
     */
    public function getCoExecutors(): array
    {
        return $this->coExecutors;
    }

    /**
     * @param array $coExecutors
     */
    public function setCoExecutors(array $coExecutors)
    {
        $this->coExecutors = $coExecutors;
    }

    /**
     * @return string
     */
    public function getTracker(): string
    {
        return $this->tracker;
    }

    /**
     * @param string $tracker
     */
    public function setTracker(string $tracker)
    {
        $this->tracker = $tracker;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }


    public function serialize(): array
    {
        return [
            substr(md5(rand()), 0, 7) => [
                "Zadacha/Zadacha" => [
                    [
                        "Opisanie_zadachi" => $this->description,
                        "Zadacha" => $this->task,
                        "Data_okonchaniya_zadachi" => $this->dateEnd,
                        "Region" => $this->region,
                        "Fail" => $this->files,
                        "Prioritet" => $this->priority,
                        "Otvetstvennyi" => $this->responsible,
                        "Roditelskaya_zadacha" => $this->parentTask,
                        "Soispolnitel" => $this->coExecutors,
                        "Treker" => $this->tracker,
                        "Status" => $this->status
                    ]
                ]
            ]
        ];
    }

    public function isAllRequiredSet(): bool
    {
        return (bool) ($this->task && $this->region && $this->status);
    }

}