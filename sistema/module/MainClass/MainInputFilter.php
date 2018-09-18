<?php
/**
 * Project: O que fazer culinária
 * ==================================
 * Dev: Rafael Silva
 * Email: contato@pantoneweb.com.br
 * Phone: +55 14 9-9747-2101
 * ==================================
 */

namespace MainClass;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Digits;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\InArray;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;


/**
 * Class MainInputFilter
 * @package MainClass
 */
class MainInputFilter extends InputFilter
{
    /**
     * @var
     */
    protected $_translate;

    /**
     * TRANSLATE
     * @param $str
     * @return string
     */
    public function translate($str)
    {
        return $str;
    }

    /**
     * SET FILTERS
     * @param $filters
     * @return array
     */
    public function setFilters($filters)
    {
        $f = [];
        foreach ($filters as $filter) {
            $f[] = ['name' => $filter];
        }
        return $f;
    }

    /**
     * GET VALIDATION BASE FOR INPUT ID
     * @param $data
     * @return mixed
     */
    public function getValidationBaseForInputID($data)
    {
        return array_merge($data, [
            'filters' => self::setFilters([
                'StripTags',
                'StringTrim',
                'ToNull',
                'Digits'
            ]),
            'validators' => [
                self::validNotEmpty(),
                self::validDigits()
            ]]);
    }

    /**
     * GET VALIDATION BASE FOR INPUT ID
     * @param $data
     * @return mixed
     */
    public function getValidationBaseForSelectID($data, $haystack)
    {
        return array_merge($data, [
            'filters' => self::setFilters([
                'StripTags',
                'StringTrim',
                'ToNull',
                'Digits'
            ]),
            'validators' => [
                self::validNotEmpty(),
                self::validDigits(),
//                self::validInArray($haystack)
            ]]);
    }

    /**
     * GET VALIDATION BASE FOR INPUT MONEY
     * @param $data
     * @return mixed
     */
    public function getValidationBaseForInputMoney($data)
    {
        return array_merge($data, [
            'filters' => self::setFilters([
                'StripTags',
                'StringTrim',
            ]),
            'validators' => [
                self::validNotEmpty(),
                self::validFloat()
            ]]);
    }

    /**
     * GET VALIDATION BASE FOR INPUT FLOAT
     * @param $data
     * @return mixed
     */
    public function getValidationBaseForInputFloat($data)
    {
        return array_merge($data, [
            'filters' => self::setFilters([
                'StripTags',
                'StringTrim',
            ]),
            'validators' => [
                self::validNotEmpty(),
                self::validFloat()
            ]]);
    }

    /**
     * GET VALIDATION BASE FOR INPUT DATE
     * @param $data
     * @return mixed
     */
    public function getValidationBaseForInputDate($data)
    {
        return array_merge($data, [
            'filters' => self::setFilters([
                'StripTags',
                'StringTrim',
                'ToNull'
            ]),
            'validators' => [
                self::validDate()
            ]]);
    }

    /**
     * GET VALIDATION BASE FOR INPUT DATE RANGE
     * @param $data
     * @return mixed
     */
    public function getValidationBaseForInputDateRange($data)
    {
        return array_merge($data, [
            'filters' => self::setFilters([
                'StripTags',
                'StringTrim',
                'ToNull'
            ]),
            'validators' => [
                self::validDateRange()
            ]]);
    }

    /**
     * GET VALIDATION BASE FOR INPUT HOUR
     * @param $data
     * @return mixed
     */
    public function getValidationBaseForInputHour($data)
    {
        return array_merge($data, [
            'filters' => self::setFilters([
                'StripTags',
                'StringTrim'
            ]),
            'validators' => [
                self::validHour()
            ]]);
    }

    /**
     * GET VALIDATION BASE FOR INPUT BOOL
     * @param $data
     * @return mixed
     */
    public function getValidationBaseForInputBool($data)
    {
        return array_merge($data, [
            'filters' => self::setFilters([
                'StripTags',
                'StringTrim',
                'ToInt',
                'Digits'
            ]),
            'validators' => [
                self::validBool()
            ]]);
    }

    /**
     * @param $data
     * @return array
     */
    public function getValidationBaseForInputInt($data)
    {
        return array_merge($data, [
            'filters' => self::setFilters([
                'StripTags',
                'StringTrim',
                'ToInt',
                'Digits'
            ]),
            'validators' => [
                self::validDigits()
            ]]);
    }

    /**
     * VALID EMAIL
     * @return EmailAddress
     */
    public function validEmail()
    {
        return new EmailAddress(array(
            'message' => array(
                \Zend\Validator\EmailAddress::INVALID => $this->translate("Invalid type given. String expected"),
                \Zend\Validator\EmailAddress::INVALID_FORMAT => $this->translate("The input is not a valid email address. Use the basic format local-part@hostname"),
                \Zend\Validator\EmailAddress::INVALID_HOSTNAME => $this->translate("'%hostname%' is not a valid hostname for the email address"),
                \Zend\Validator\EmailAddress::INVALID_MX_RECORD => $this->translate("'%hostname%' does not appear to have any valid MX or A records for the email address"),
                \Zend\Validator\EmailAddress::INVALID_SEGMENT => $this->translate("'%hostname%' is not in a routable network segment. The email address should not be resolved from public network"),
                \Zend\Validator\EmailAddress::DOT_ATOM => $this->translate("'%localPart%' can not be matched against dot-atom format"),
                \Zend\Validator\EmailAddress::QUOTED_STRING => $this->translate("'%localPart%' can not be matched against quoted-string format"),
                \Zend\Validator\EmailAddress::INVALID_LOCAL_PART => $this->translate("'%localPart%' is not a valid local part for the email address"),
                \Zend\Validator\EmailAddress::LENGTH_EXCEEDED => $this->translate("The input exceeds the allowed length"),
            )));
    }

    /**
     * VALID FLOAT
     * @return array
     */
    public function validFloat()
    {
        return [
            'name' => 'Callback',
            'options' => array(
                'messages' => array(
                    \Zend\Validator\Callback::INVALID_VALUE => $this->translate("The proximity value should be numbers")
                ),
                'callback' => function ($value, $context = array()) {
                    $value = MainController::formatMoneyDb($value);
                    return is_numeric($value);
                }
            )
        ];
    }

    /**
     * VALID BOOL
     * @return array
     */
    public function validBool()
    {
        return [
            'name' => 'Callback',
            'options' => array(
                'messages' => array(
                    \Zend\Validator\Callback::INVALID_VALUE => $this->translate("Invalid value")
                ),
                'callback' => function ($value, $context = array()) {
                    return (is_numeric($value) && in_array($value, [0, 1]));
                }
            )
        ];
    }

    /**
     * VALID DATE
     * format date YYYY-mm-dd
     * @return array
     */
    public function validDate()
    {
        return [
            'name' => 'Callback',
            'options' => array(
                'messages' => array(
                    \Zend\Validator\Callback::INVALID_VALUE => $this->translate("Invalid date")
                ),
                'callback' => function ($value, $context = array()) {
                    $date = explode('-', $value);
                    if (is_array($date)) {
                        return checkdate($date[1], $date[2], $date[0]);
                    }
                    return false;
                }
            )
        ];
    }

    /**
     * @return array
     */
    public function validDateRange()
    {
        return [
            'name' => 'Callback',
            'options' => array(
                'messages' => array(
                    \Zend\Validator\Callback::INVALID_VALUE => $this->translate("Invalid date")
                ),
                'callback' => function ($value, $context = array()) {
                    if (preg_match('/^(\d{1,2}\/\d{1,2}\/\d{4})* até (\d{1,2}\/\d{1,2}\/\d{4})$/', $value)) {

                        $dateRange = MainController::prepareDateRange($value);

                        /**
                         * START
                         */
                        $date1 = explode('-', $dateRange['start']);
                        if (is_array($date1)) {
                            $date1Res = checkdate($date1[1], $date1[2], $date1[0]);
                        }
                        /**
                         * END
                         */
                        $date2 = explode('-', $dateRange['end']);
                        if (is_array($date2)) {
                            $date2Res = checkdate($date2[1], $date2[2], $date2[0]);
                        }

                        /**
                         * DATE START > DATE END
                         */
                        $dateRangeValid = (strtotime($dateRange['end']) >= strtotime($dateRange['start']));

                        return ($date1Res === true && $date2Res === true && $dateRangeValid === true);
                    }
                    return false;
                }
            )
        ];
    }


    /**
     * VALID HOUR
     * @return array
     */
    public function validHour()
    {
        return [
            'name' => 'Callback',
            'options' => array(
                'messages' => array(
                    \Zend\Validator\Callback::INVALID_VALUE => $this->translate("Invalid hour")
                ),
                'callback' => function ($value, $context = array()) {
                    return (!preg_match("^([0-1][0-9]|[2][0-3]):[0-5][0-9]$^", $value));
                }
            )
        ];
    }


    /**
     * VALID DIGITS
     * @return Digits
     */
    public function validDigits()
    {
        return new Digits(array(
            'message' => array(
                \Zend\Validator\Digits::NOT_DIGITS => $this->translate("The input must contain only digits"),
                \Zend\Validator\Digits::STRING_EMPTY => $this->translate("The input is an empty string"),
                \Zend\Validator\Digits::INVALID => $this->translate("Invalid type given. String, integer or float expected"),
            )));
    }

    /**
     * VALID NOT EMPTY
     * @return NotEmpty
     */
    public function validNotEmpty()
    {
        return new NotEmpty(array(
            'message' => array(
                \Zend\Validator\NotEmpty::IS_EMPTY => $this->translate("Value is required and can't be empty"),
            )));
    }

    /**
     * VALID STRING LENGTH
     * @param $min
     * @param $max
     * @return StringLength
     */
    public function validStringLength($min, $max)
    {
        return new StringLength(array(
            'min' => $min,
            'max' => $max,
            'messages' => array(
                \Zend\Validator\StringLength::TOO_SHORT => $this->translate("Tell more than %min% characters"),
                \Zend\Validator\StringLength::TOO_LONG => $this->translate("Maximum quantity %max% characters")
            )));
    }

    /**
     * VALID IN ARRAY
     * @param $haystack
     * @return InArray
     */
    public function validInArray($haystack)
    {
        return new InArray(array(
            'haystack' => $haystack,
            'messages' => array(
                \Zend\Validator\InArray::NOT_IN_ARRAY => $this->translate("The input was not found in the haystack"),
            )));
    }

    /**
     * VALID IN Identical
     * @param $token
     * @return Identical
     */
    public function validIdentical($token)
    {
        return new Identical(array(
            'token' => $token,
            'messages' => array(
                \Zend\Validator\Identical::NOT_SAME => $this->translate("The two data tokens do not match"),
                \Zend\Validator\Identical::MISSING_TOKEN => $this->translate("No characters have been provided for"),
            )));
    }
}
