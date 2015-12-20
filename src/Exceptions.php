<?php

/**
 * @author     Ignas Rudaitis <ignas.rudaitis@gmail.com>
 * @copyright  2010-2015 Ignas Rudaitis
 * @license    http://www.opensource.org/licenses/mit-license.html
 * @link       http://antecedent.github.com/patchwork
 */
namespace Patchwork\Exceptions;

use Patchwork\Utils;

abstract class Exception extends \Exception
{
}

class NoResult extends Exception
{
}

class StackEmpty extends Exception
{
    protected $message = "There are no calls in the dispatch stack";
}

abstract class CallbackException extends Exception
{
    function __construct($callback)
    {
        parent::__construct(sprintf($this->message, Utils\callableToString($callback)));
    }
}

class NotUserDefined extends CallbackException
{
    protected $message = "%s is not a user-defined function or method";
}

class DefinedTooEarly extends CallbackException
{

    function __construct($callback)
    {
        $this->message = "The file that defines %s() was included earlier than Patchwork. " .
                         "This is likely a result of an improper setup; see wiki for details.";
        parent::__construct($callback);
    }
}

class CacheLocationUnavailable extends Exception
{
    function __construct($location)
    {
        parent::__construct(sprintf(
            "The specified cache location is inexistent or read-only: %s",
            $location
        ));
    }
}

class ConfigMissing extends Exception
{
    public function __construct()
    {
        parent::__construct('No patchwork.json was found in directories enclosing any included files');
    }
}
