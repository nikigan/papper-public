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

    public function sumClass()
    {
        if ($this->model->status == DocumentStatus::CONFIRMED) {
            if ($this->model->document_type) {
                return 'text-success';
            } else {
                return 'text-danger';
            }
        }

        return "";
    }

    public function sum()
    {
        $nf = numfmt_create('he_IL', \NumberFormatter::CURRENCY);
        $minus = $this->model->document_type === 0 ? '-' : '';
        return numfmt_format_currency($nf, $this->model->sum, $this->model->currency->ISO_code);
    }

    public function vat()
    {
        $nf = numfmt_create('he_IL', \NumberFormatter::CURRENCY);
        $minus = $this->model->document_type === 0 ? '-' : '';
        return numfmt_format_currency($nf, $this->model->vat, $this->model->currency->ISO_code);
    }
}
