Ceive.Data.Autocomplete
=======================

Component a helper autocomplete oriented system create


Суть заключается в различных Автокомплитах, которые представляют простой объект аттрибутов значениями которых являются типы этих атрибутов.

**Автокомплиты бывают следующие:**

  * Простой автокомплит - автокомплит не имеющий привязки к классу или субъекту, он отражает простой контекст атрибутов, и на него нельзя ссылаться по названию класса или субъекта
  * Автокомплит класса - Это список атрибутов который можно заполучить по ссылке, которая может указываться в любых автокомплитах в качестве типа(значения атрибута)

**Автокомплит** - это прежде всего маска для **СТРУКТУРЫ ДАННЫХ** которую автокомплит собственно и пытается представить.


**Автокомплит** - изначально описывает маску **СТРУКТУРЫ ДАННЫХ** не считая, что эта самая структура может в определенных условиях составлять другую более большую структуру, поэтому есть такое понятие как **Вложенный автокомплит**..


**Вложенный автокомплит** - Декорирует простой автокомплит, полностью повторяя его интерфейс, только задачей такого декоратора является перехват запроса на автокомплит по пути по которому производится запрос, и если вложенность запроса и настройка вложенности нашего вкладываемого автокомплита совпадает то происходит слитие атрибутов декорируемого автокомплита со своими. Таким образом можно переопределить понимание одного и того же автокомплита примененных в разных  вложенных иерархиях и атрибутных контекстах

Спецификация типа в автокомплите:

  * Любые скаляры `[integer, string, float, null, boolean]`
  * Объект,указывается не напрямую, а преимущественно через ссылку

Так-же автокомплит кроме технической пользы может указывать локализованные Названия и описания для того чтобы обеспечить максимально удобную поддержку для пользователя UI

Так-же, у пакета **Автокомплит** есть похожий пакет **Data Structure Interface**, у которого в отличие от автокомплита, имеются Контроль типа(Валидация структуры) и возможность определения достаточно сложных Подсказок по типам, наподобие типам в TypeScript


```
namespace Ceive\Data\Autocomplete;

$manager = new Manager();


$manager->register(new AutocompleteClass('User',[
    'username'      => 'string',
    'password'      => 'string',
    'login_counts'  => 'int',
    'profile'       => '<User\Profile>'
]));

$manager->register(new AutocompleteClass('User\Profile',[
    'first_name'        => 'string',
    'last_name'         => 'string',
    'second_name'       => 'string',
    'user'              => '<User>'
]));

$manager->register($autocomplete = new Autocomplete([
    'user' => '<User>',
    'value' => 'mixed',
]));


$user = $manager->getByClassname('User');

$entries = $autocomplete->entries();

$this->assertEquals([
    'user' => '<User>',
    'value' => 'mixed',
],$autocomplete->entries());


$this->assertEquals([
    'user' => '<User>',
],$autocomplete->entriesLink());

// Language Labeled
//$autocomplete->getTitle($entry);
//$autocomplete->getDescription($entry);
//$autocomplete->getType($entry);

// AbsolutePath
//$autocomplete->getAbsolutePath($entry_key);


$label = [
    'lang'          => null,
    'key'           => 'user',
    'description'   => null,

    'cases' => [[
        'lang'          => 'ru_RU',
        'title'         => 'пользователь',
        'description'   => 'описание'
    ]]
];

$label = [
    'lang'          => null,
    'key'           => 'current_user',
    'description'   => null,

    'cases' => [[
        'lang'          => 'ru_RU',
        'title'         => 'текущий пользователь',
        'description'   => 'пользователь, который в момент выполнения проводит авторизованное действие'
    ]]
];


```