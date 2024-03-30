var intervalTimer = [];

    function cardOnload() {
        var card = document.getElementsByClassName("CardSite");
        for (let i = 0; i < card.length; i++) {
            var elementRecup = card[i].children[0].children[1];
            var element = card[i].children[0].children[0];
            splitTitle = elementRecup.innerHTML.split(", ");
            id = splitTitle[0];
            datefinal = splitTitle[1];

            setTimerInterval(element, id, datefinal);
        }
        
    }

    function setTimerInterval(element, id, datefinal) {
        intervalTimer[id] = setInterval(setTimer, 1000, element, datefinal);
    }

    function setTimer(element, datefinal) {

        var splitDateFinal = datefinal.split(' ');
        var finalYMD = splitDateFinal[0];
        var splitFinalYMD = finalYMD.split('-');
        var finalY = splitFinalYMD[0];
        var finalMonth = splitFinalYMD[1];
        var finalD = splitFinalYMD[2];
        var finalHMS = splitDateFinal[1];
        var splitFinalHMS = finalHMS.split(':');
        var finalH = splitFinalHMS[0];
        var finalMinutes = 0;
        var finalS = splitFinalHMS[2];
        
        var currentdate = new Date();

        var Year = currentdate.getFullYear();
        var Month = currentdate.getMonth() + 1;
        var Day = currentdate.getDate();
        var Hour = currentdate.getHours();
        var Minute = currentdate.getMinutes();
        var Second = currentdate.getSeconds();

        var newTimer = "";
        var newNewYear, newNewMonth, newNewDay, newNewHour, newNewMinute, newNewSecond;

        var newYear = finalY - Year;
        if (newYear > 0) {
            newNewYear = newYear - 1;
            if (newNewYear == 1) {
                newTimer = newTimer + newNewYear + "An ";
            } else if (newNewYear > 1) {
                newTimer = newTimer + newNewYear + "Ans ";
            }
        }

        var newMonth = subtractMonth(finalMonth, Month, newYear);
        if (newMonth > 0 || newYear > 0) {
            newNewMonth = newMonth - 1;
            if (newNewMonth > 0) {
                newTimer = newTimer + newNewMonth + "mois ";
            } else if (newYear > 0) {
                newTimer = newTimer + newNewMonth + "mois ";
            }
        }
           
        var newDay = subtractD(finalD, Day, Month, Year, newMonth);
        if (newDay > 0 || newYear > 0 || newMonth > 0) {
            newNewDay =  newDay - 1;
            if (newNewDay > 0) {
                if (newNewDay == 1) {
                    newTimer = newTimer + newNewDay + "Jour<br>";
                } else {
                    newTimer = newTimer + newNewDay + "Jours<br>";
                }
            } else if (newYear > 0 || newMonth > 0) {
                if (newNewDay == 0) {
                    newTimer = newTimer + newNewDay + "Jour<br>";
                } else {
                    newTimer = newTimer + newNewDay + "Jours<br>";
                }
            }
        }

        var newHour = subtractH(finalH, Hour, newDay);
        if (newHour > 0 || newDay > 0 || newYear > 0 || newMonth > 0) {
            newNewHour = newHour - 1;
        }

        var newMinute = subtractMin(finalMinutes, Minute, newHour);
        if (newMinute > 0 || newHour > 0 || newDay > 0 || newYear > 0 || newMonth > 0) {
            newNewMinute = newMinute - 1;
        }

        var newSecond = subtractS(finalS, Second, newMinute);
        if (newSecond > 0 || newMinute > 0 || newHour > 0 || newDay > 0 || newYear > 0 || newMonth > 0) {
            newNewSecond = newSecond - 1;
        }

        newTimer = newTimer + newNewHour + ":";
        newTimer = newTimer + newNewMinute + ":";
        newTimer = newTimer + newNewSecond;
        
        element.innerHTML = newTimer;
    }

    function subtractMonth(final, current, year) {
        if (final == current) {
            if (year == 0) {
                var newOne = 0;
            } else {
                var newOne = 12;
            }
        } else if (final < current) {
            var newOne = 12 - (current - final);
        } else {
            var newOne = final - current;
        }

        return newOne;
    }

    function subtractD(final, current, currentmonth, currentyear, month) {
        var lastD;
        if (currentmonth == (4 || 6 || 9 || 11 )) {
            lastD = 30;
        } if (current == 2) {
            if (currentyear % 4 == 1) {
                lastD = 28;
            } else {
                lastD = 29;
            }
        } else {
            lastD = 31;
        }

        if (final == current) {
            if (month == 0) {
                var newOne = 0;
            } else {
                var newOne = lastD;
            }
        } else  if (final < current) {
            var newOne = lastD - (current - final);
        } else {
            var newOne = final - current;
        }

        return newOne;
    }

    function subtractH(final, current, day) {
        if (final == current) {
            if (day == 0) {
                var newOne = 0;
            } else {
                var newOne = 24;
            }
        } else  if (final < current) {
            var newOne = 24 - (current - final);
        } else {
            var newOne = final - current;
        }

        return newOne;
    }

    function subtractMin(final, current, hour) {
        if (final == current) {
            if (hour == 0) {
                var newOne = 0;
            } else {
                var newOne = 60;
            }
        } else  if (final < current) {
            var newOne = 60 - (current - final);
        } else {
            var newOne = final - current;
        }

        return newOne;
    }

    function subtractS(final, current, minute) {
        if (final == current) {
            if (minute == 0) {
                var newOne = 0;
            } else {
                var newOne = 60;
            }
        } else  if (final < current) {
            var newOne = 60 - (current - final);
        } else {
            var newOne = final - current;
        }

        return newOne;
    }

    window.addEventListener("load", (event) => {
        cardOnload();
    });