<?php

    $example_persons_array = [
        [
            'fullname' => 'Иванов Иван Иванович',
            'job' => 'tester',
        ],
        [
            'fullname' => 'Степанова Наталья Степановна',
            'job' => 'frontend-developer',
        ],
        [
            'fullname' => 'Пащенко Владимир Александрович',
            'job' => 'analyst',
        ],
        [
            'fullname' => 'Громов Александр Иванович',
            'job' => 'fullstack-developer',
        ],
        [
            'fullname' => 'Славин Семён Сергеевич',
            'job' => 'analyst',
        ],
        [
            'fullname' => 'Цой Владимир Антонович',
            'job' => 'frontend-developer',
        ],
        [
            'fullname' => 'Быстрая Юлия Сергеевна',
            'job' => 'PR-manager',
        ],
        [
            'fullname' => 'Шматко Антонина Сергеевна',
            'job' => 'HR-manager',
        ],
        [
            'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
            'job' => 'analyst',
        ],
        [
            'fullname' => 'Бардо Жаклин Фёдоровна',
            'job' => 'android-developer',
        ],
        [
            'fullname' => 'Шварцнегер Арнольд Густавович',
            'job' => 'babysitter',
        ],
    ];

    /** Разбиение и объединение ФИО */

    function getPartsFromFullname($surname, $name, $middleName) {
        return $surname.' '.$name.' '.$middleName;
    }

    function getFullnameFromParts($fullName) {
        $partName = explode(' ', $fullName);
        return ['surname' => $partName[0], 'name' => $partName[1], 'patronomyc' => $partName[2]];
    }

    function getShortName($fullName) {
        $partName = getFullnameFromParts($fullName);
        return $partName['name'].' '.mb_substr($partName['surname'], 0, 1).'.';
    }

    function getGenderFromName($fullName) {
        $genderMark = 0;
        $partName = getFullnameFromParts($fullName);

        foreach ($partName as $key => $value) {
            $check = isGender($key, $value);
            if ($check > 0) {
                $genderMark++;
            } elseif($check < 0) {
                $genderMark--;
            }
        }

        return $genderMark <=> 0;
    }

    function isGender($key, $value) {
        $result = 0;
        switch($key) {
            case 'surname':
                if (str_ends_with($value, 'ва')) $result = -1;
                if (str_ends_with($value, 'в')) $result = 1;
                break;
            case 'name':
                if (str_ends_with($value, 'а')) $result = -1;
                if (str_ends_with($value, 'й') | str_ends_with($value, 'н')) $result = 1;
                break;
            case 'patronomyc':
                if (str_ends_with($value, 'вна')) $result = -1;
                if (str_ends_with($value, 'ич')) $result = 1;
                break;
        }
        return $result;
    }

    function  getGenderDescription($array) {
        $size = count($array);

        $male = array_filter($array, function($value) {
            return getGenderFromName($value['fullname']) > 0;
        });
        $female = array_filter($array, function($value) {
            return getGenderFromName($value['fullname']) < 0;
        });

        $maleCount = count($male);
        $femaleCount = count($female);

        echo '<b>Гендерный состав аудитории:</b><br />';
        echo '-----------------------------------------<br />';
        $malePercent = round(($maleCount / $size * 100), 1);
        $femalePercent = round(($femaleCount / $size * 100), 1);
        $other = round((($size - ($maleCount + $femaleCount)) / $size * 100), 1);

        echo "Мужчины - $malePercent<br />";
        echo "Женщины - $femalePercent<br />";
        echo "Не удалось определить - $other<br />";
    }

    function getPerfectPartner($surname, $name, $patronomyc, $array) {
        $fullName = mb_convert_case(getPartsFromFullname($surname, $name, $patronomyc), MB_CASE_TITLE);
        $sex = getGenderFromName($fullName);
        $size = count($array) - 1;
        while (true) {
            $randomIndex = rand(0, $size);
            $partner = $array[$randomIndex]['fullname'];
            $partnerSex = getGenderFromName($partner);
            if ($sex != $partnerSex & $sex != 0 & $partnerSex != 0) {
                break;
            }
            $randomIndex = 0;
            $partner = '';
        }
        $shortName1 = getShortName($fullName);
        $shortName2 = getShortName($partner);
        $percent = round(rand(5000, 10000) / 100, 2);
        
        echo $shortName1.' + '.$shortName2.' =<br />';
        echo "\u{2661} Идеально на ".$percent."% \u{2661}";
    }

    getGenderDescription($example_persons_array);
    echo '<br />';
    getPerfectPartner('СОКОЛОВ', 'РОман', 'ЮрьевиЧ', $example_persons_array);
?>