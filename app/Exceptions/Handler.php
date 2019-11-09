<?php

namespace App\Exceptions;
use DB;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
       
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        
        
       
      /* $class=get_class($e);
        if($class. contains("stripe"))
        {
         $inURL=$_SERVER['REQUEST_URI'];
        if(strtolower($inURL). contains("saveorderwithoutmenu") )
        {
            $message=$e->getMessage();
            $request["restaurantid"];
            
            $strquery="select ";
            
             // disable last order of user.
        }
        }
        else{

        }*/
        
     return parent::render($request, $e);


       
    }
}
