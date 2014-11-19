<?php
/*
====+++========
Open Tibia XML Data Validator
Under GPL v3 License
Author: Pavlus
Language file
====+++========
*/

require_once('./config.php'); //this line must be included!

//error messages

$error['php_version'] = 'Twoja wersja PHP jest przestarzała, wymagane jest co najmniej PHP w wersji > 5.0.0';
$error['directory'] = 'Ścieżka do folderów account, players lub vip jest niepoprawna, musisz zmienić to w config.php.';
$error['simplexml'] = 'Funkcja simplexml_load_file niedostępna, sprawdź php.ini';
$error['unlink'] = 'Twoje PHP nie supportuje funkcji unlink, zmień ustawienia w php.ini.';
$error['xml_syntax'] = 'Błąd krytyczny, składnia XML niepoprawna!';
$error['wrong_digits'] = 'Liczba cyfr w numerze konta inna niż: '.$account['digits'].'';
$error['empty_pass'] = 'Puste hasło';
$error['wrong_type'] = 'Zły account type';
$error['prem_without_value'] = 'Atrybut premDays nie zawiera żadnej wartości';
$error['prem_not_int'] = 'Atrybut premDays nie jest wartością numeryczną';
$error['prem_less_zero'] = 'Atrybut premDays jest mniejszy od zera!';
$error['prem_max'] = 'Liczba dni premium jest większa niż: '.$premDay['limit'].'';
$error['empty_account'] = 'Plik konta nie zawiera postaci';
$error['account_max'] = 'Maksymalna liczba postaci na koncie: ('.$maxchars.') przekroczona';
$error['account_miss'] = 'Plik account nie istnieje dla tego gracza';
$error['sum'] = 'Liczba błędów:';
$error['deleting'] = 'Błąd podczas usuwania, musisz mieć prawa odczytu i zapisu!<br>';
$error['unlinked'] = 'Liczba usuniętych plików:';
$error['changed'] ='Liczba zmienionych plików:';
$error['sex_numeric'] = 'Atrybut sex nie jest wartością numeryczną';
$error['sex_value'] = 'Atrybut sex ma nieprawidłową wartość';
$error['lookdir_value'] = 'Atrybut lookdir ma nieprawidłową wartość';
$error['exp_value'] = 'Atrybut exp ma nieprawidłową wartość';
$error['vip_exists'] = 'Plik viplisty dla tego konta, nie powinien istnieć';

//header msg

$head['title'] = 'XML VALIDATOR RAPORT';
$head['version'] = 'WERSJA';
$head['date'] = 'WYKONANO';
$head['file_count'] = 'PRZESKANOWANYCH PLIKÓW';


//raport output titles

$title['vip'] = 'Sprawdzanie viplisty: OK';
$title['exp'] = 'Sprawdzanie experience: OK';
$title['lookdir'] = 'Sprawdzanie lookdir: OK';
$title['sex_dig'] = 'Sprawdzanie sex: OK'; 
$title['digits'] = 'Sprawdzanie liczb numeru konta: OK';
$title['pass'] = 'Sprawdzanie haseł: OK';
$title['types'] = 'Sprawdzanie typów: OK';
$title['prem'] = 'Sprawdzanie premDays: OK';
$title['char'] = 'Sprawdzanie postaci: OK';
$title['acc_num'] = 'Sprawdzanie numerów kont: OK';

//head messages, what kind of files we examined

$mode['accounts'] = 'Wyniki sprawdzania folderu accounts';
$mode['players'] = 'Wyniki sprawdzania folderu players';

//misc

$misc['core_changed'] = 'Główny plik Validatora został zmieniony! Uruchamiasz go teraz na własną odpowiedzialność';
$misc['raport_chmod'] = 'Katalog LOG powinien miec możliwość odczytu i zapisu przez właściciela (chmod 777)';
$sec = 'sek';
$gener = 'Trwa generowanie raportu, proszę czekać';
$eta = 'Test może potrwać od kilku sekund do kilku minut, w zależności od liczby plików do przeskanowania';



?>
