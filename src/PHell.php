<?php

namespace PHell;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHell\Exceptions\ExceptionInPHell;
use PHell\Exceptions\ShouldntHappenException;
use PHell\Exceptions\SyntaxErrorException;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\ExceptionEndHandler;
use PHell\Flow\Main\Lib;
use PHell\Flow\Main\Returns\CatapultReturnLoad;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Runtime;

class PHell
{

    private Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger('PHell');
        $defaulLogcation = __DIR__.'/../run.log';
        $stream = fopen($defaulLogcation, 'w');
        $this->logger->pushHandler(new StreamHandler($stream));
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function setLogger(Logger $logger): void
    {
        $this->logger = $logger;
    }

    //TODO maybe getVersion()

    /**
     * @throws \Throwable
     */
    public function execute(Code $code)
    {
        $runtime = new Runtime($code);
        try {
            $rl = $runtime->getValue($runtime, new ExceptionEndHandler($this->getLogger()));
        } catch (ShouldntHappenException $shouldntHappenException) {
            //log with 450 Error to Critical
            $this->logger->log(500, $shouldntHappenException);
            throw $shouldntHappenException;
        } catch (SyntaxErrorException $syntaxErrorException) {
            //thrown when public/protected is used unwisely //TODO maybe change this exception
            $this->logger->log(400, 'Program ended prematurely to an SyntaxError');
            throw $syntaxErrorException;
        } catch (\Throwable $exception) {
            $this->logger->log(400, $exception);
            throw $exception;
        }

        if ($rl instanceof DataReturnLoad) {
            $this->logger->log(0, 'Program successfully executed with return');
            return $rl->getData()->phpV();
        } elseif ($rl instanceof ExceptionReturnLoad) {
            //already logged in ExceptionEndHandler
            throw new ExceptionInPHell($rl);
        } elseif ($rl instanceof CatapultReturnLoad) {
            //wtf should not happen - but can happen
            $this->logger->log(100,'Program ended due to a CatapultReturn to the very top');
            return $rl->getData()->phpV();
        } else {
            //can only happen with modifications
            //no idea, i guess
            $this->logger->log(400, 'Program ended due to unknown returnload: '.PHP_EOL. Lib::dumpAsString($rl));
        }

        $this->logger->log(0, 'Program successfully executed without return');
        echo 'done';
        return 'Program successfully executed';
    }


}