<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class BuildException extends Exception
{
    protected $message;

    protected $code;

    protected $transportedData;

    protected string $shortMessage;

    protected string $description;

    protected string $help;

    protected string $transportedMessage;

    protected string $httpCode;

    public function __construct(array $exception)
    {
        $this->shortMessage       = Arr::get($exception, 'shortMessage', 'internalError');
        $this->message            = Arr::get($exception, 'message', trans('exceptions.internal_error'));
        $this->description        = Arr::get($exception, 'description', '');
        $this->help               = Arr::get($exception, 'help', '');
        $this->transportedMessage = Arr::get($exception, 'transportedMessage', '');
        $this->httpCode           = Arr::get($exception, 'httpCode', Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->transportedData    = Arr::get($exception, 'transportedData', '');
        $this->code               = $this->shortMessage;

        parent::__construct();
    }

    public function render()
    {
        return response($this->getError(), $this->httpCode);
    }

    public function getError(): array
    {
        return [
            'shortMessage'       => $this->shortMessage,
            'message'            => $this->message,
            'description'        => $this->description,
            'help'               => $this->help,
            'transportedMessage' => $this->transportedMessage,
            'transportedData'    => $this->transportedData,
        ];
    }

    public function getShortMessage(): string
    {
        return $this->shortMessage;
    }
}
