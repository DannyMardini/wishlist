<?php
namespace util;

class Time
{
    public static function getFormattedTimestamp()
    {
        $submittedDateTime = strtotime($this->getDatetime());
        $thisYear = date('Y') == date('Y', $submittedDateTime);

        if ( $thisYear > 0 )
        {
            $thisWeek = date('W') == date('W', $submittedDateTime);
            if( $thisWeek > 0 )
            {
                $yesterday = date('j', $submittedDateTime) == (date('j')-1);
                $today = date('j') == date('j', $submittedDateTime);

                if( $yesterday > 0 )
                {
                    return " Yesterday @ ".date("g:i a", $submittedDateTime);
                }
                else if( $today > 0 )
                {
                    return "Today @".date(" g:i a", $submittedDateTime);
                }
                else
                {
                    return date(  "l \@ g:i a", $submittedDateTime);
                }
            }
            else
            {
                return date(  "F jS \@ g:i a", $submittedDateTime);
            }
        }
        else
        {
            $seconds = time() - $submittedDateTime;
            $days = round($seconds / (24*60*60));

            $yesterday = $days <= 1;
            $thisWeek = (round($days / 7)) <= 1;

            if($yesterday > 0)
            {
                return " yesterday @ ".date("g:i a", $submittedDateTime);
            }
            else if($thisWeek > 0)
            {
                return date(  "l \@ g:i a", $submittedDateTime);
            }
            else
            {
                return date(  "F jS, Y, g:i a", $submittedDateTime);
            }
        }
    }
}
?>
