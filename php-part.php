<?php
/**
 * Created by PhpStorm.
 * User: SbWereWolf
 * Date: 2019-04-08
 * Time: 16:34
 */

/*
 * Комментарии к заданию и решению
 *
 * Обработка ошибок отсутствует, если что то пошло не так, то ни одна функция вам об этом не сообщит
 * Только вычисление значения числа записаного произвольной строкой с произвольным основанием, выдаст -1,
 * и вызывающий код должен это обработать
 * Ошибки формата входных данных не проверяются, не обрабатываются
 *
 * в ТЗ было требование реализовтаь вычисления самым быстрым способом, разные способы не реализовывал и не оценивал
 *
 * Задание с вычислением значения числа записанного произвольной строкой самое убойное, с точки зрения проверки
 * для двоичной, шестнадцатиричной, для десятичное всё ок,
 * но вот когда пытаешься проверить тридцатишестиричную системы исчисления .. тут мозг ожидаемо даёт сбой
 *
 * вообще я привык классами писать, но в тестовых всегда процедурый подход,
 * потому что ради одного метода огород городить .., поэтому если ожидалось ООП, то извините
 *
 * тестов нет, тоже простите, но одноразовость кода непредполагает тесты, если о них не просили.
 *
 * PS
 * Такие задачки последний раз решал в институте, кроме возведения в степень не очень понимаю к чему остальные,
 * вы кажется ожидаете проектирования архитектуры, а задачки даёте на кодирование (на микро-оптимизации ?)
 * */

/*
4. Напишите свой (без использования array_sum() и других встроенных функций работы с массивами) самый быстрый метод,
 вычисляющий сумму значений массива [2‚ 4‚ 6‚ 8‚ 10 … 100]
*/
function customArrayAdder(array $numbers): int
{
    $sum = 0;
    foreach ($numbers as $element) {
        $sum += $element;
    }
    return $sum;
}

echo customArrayAdder(array(2, 4, 6, 8, 10, 100)) . "\n";

/*
5. Есть текст с названиями городов через пробел и запятую. Например: “Москва, Орёл, Ленинград, Оренбург,
Нижний Новгород, Великий Новгород, Белгород, Орск”. Переставьте названия городов так‚ чтобы они были упорядочены по
алфавиту.
*/
const DELIMITER = ", ";
function customListSorter(string $names): string
{
    $exploded = explode(DELIMITER, $names);
    sort($exploded);
    $result = implode(DELIMITER, $exploded);

    return $result;
}

echo customListSorter("Москва, Орёл, Ленинград, Оренбург, Нижний Новгород, Великий Новгород, Белгород, Орск")
    . "\n";

/*
6. Дано: $number и $x, где $number - число, записанное в $x-ричной форме. Посчитать сумму цифр $number максимально
быстрым способом.
*/

/**
 * Инициализация алфавита системы исчисления
 *
 * @param string $rawAlphabet строка с алфавитом
 * @return array алфавит - сопоставление цифры и величины
 */
function initializeAlphabet(string $rawAlphabet, int $x)
{
    $result = explode(DELIMITER, $rawAlphabet);
    $result = array_slice($result, 0, $x);
    return $result;
}

/**
 * Возведение числа в произволную степень
 *
 * @param int $number число
 * @param int $power в какую степень
 * @return int значение числа $number в степени $power
 */
function raiseToAPower(int $number, int $power): int
{
    if ($power > 0) {
        $value = 1;
    }
    for ($index = 1; $index < $power; $index++) {
        $value *= $number;
    }

    return $value;
}

const BOTTOM_BOUND = 0;
const UPPER_BOUND = 37;
const ALPHABET =
'0, 1, 2, 3, 4, 5, 6, 7, 8, 9, a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z';
function calculateValueOfNumber(string $number, int $x): int
{
    $result = -1;
    $isCorrect = $x > BOTTOM_BOUND && $x < UPPER_BOUND;
    if ($isCorrect) {
        $alphabet = initializeAlphabet(ALPHABET, $x);
        $footing = str_split($number);
        $power = count($footing);

        $result = 0;
        foreach ($footing as $digit) {
            $digitValue = array_search($digit, $alphabet);
            $result += $digitValue * raiseToAPower($x, $power);
            $power--;
        }
    }
    return $result;
}

echo strval(calculateValueOfNumber('10', 36)) . "\n";
echo strval(calculateValueOfNumber('1111', 2)) . "\n";
echo strval(calculateValueOfNumber('f', 16)) . "\n";
echo strval(calculateValueOfNumber('15', 10)) . "\n";

/*
7. Проверить корректность расстановки круглых скобок - только символы “(“ и “)” - в строке. Между скобками допустимы
любые символы. Валидной считается строка, где все скобки правильно открыты и закрыты.
*/
const LEFT_PARENTHESES = '(';
const RIGHT_PARENTHESES = ')';
function validateParentheses(string $input): bool
{
    $parenthesesCounter = 0;
    $symbols = str_split($input);
    foreach ($symbols as $element) {
        if (LEFT_PARENTHESES == $element) {
            $parenthesesCounter++;
        }
        if (RIGHT_PARENTHESES == $element) {
            $parenthesesCounter--;
        }
        if ($parenthesesCounter < 0) {
            break;
        }
    }
    $result = $parenthesesCounter == 0;

    return $result;
}

var_export(validateParentheses('sljkfdnenk)ln('));
echo "\n";
var_export(validateParentheses('sljkfdnenk(ln)'));
echo "\n";
