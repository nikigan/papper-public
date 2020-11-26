<?php


namespace Vanguard\Presenters;


use Vanguard\Support\Enum\DocumentStatus;

class DocumentPresenter extends Presenter
{
    /**
     * Determine css class used for status labels
     * inside the users table by checking user status.
     *
     * @return string
     */
    public function labelClass()
    {
        switch ($this->model->status) {
            case DocumentStatus::CONFIRMED:
                $class = 'success';
                break;

            case DocumentStatus::REJECTED:
                $class = 'danger';
                break;

            default:
                $class = 'warning';
        }

        return $class;
    }
}
