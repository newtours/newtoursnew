<?php

namespace Drupal\tours\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'MainPageDefaultBlock' block.
 *
 * @Block(
 *  id = "main_page_default_block",
 *  admin_label = @Translation("Main Page  default block"),
 * )
 */
class MainPageDefaultBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
         'tour_name' => $this->t(''),
        ] + parent::defaultConfiguration();

 }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['tour_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Tour Name'),
      '#description' => $this->t('Tour Main name'),
      '#default_value' => $this->configuration['tour_name'],
      '#maxlength' => 255,
      '#size' => 64,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['tour_name'] = $form_state->getValue('tour_name');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $topCard = [
      'img'=>[
        '/sites/default/files/images/carousel/a-visit-at-the-aiguebelle-s-pa-1408858.jpg',
        '/sites/default/files/images/carousel/boston-at-night-1447123.jpg',
        '/sites/default/files/images/carousel/delicate-arch-3-1391955.jpg',
        '/sites/default/files/images/carousel/canada-1368175.jpg',
        '/sites/default/files/images/carousel/mexico-1-1525628.jpg',

        '/sites/default/files/images/carousel/medieval-town-1544765.jpg'
      ],
      'title'=>[
        'Праздничные туры'
      ],
      'toptitle'=>'Holidays',
      'subtitle'=>[],
      'content'=>[
        ['start'=>'06-23',
          'end'=>'07-14',
          'text'=>'День независимости',
          'link'=>'/holidays/independence',
          'calendar'=>'23  - 14 2020'
        ],
        ['start'=>'08-24',
          'end'=>'09-11',
          'text'=>'Labor Day',
          'link'=>'/holidays/labor'
        ],
        ['start'=>'09-30',
          'end'=>'10-05',
          'text'=>'День Колумба',
          'link'=>'/holidays/columbus'
        ],
        ['start'=>'11-21',
          'end'=>'11-30',
          'text'=>'Thanksgiving',
          'link'=>'/holidays/thanksgiving'
        ],

      ],
    ];
    $centralContent = [
      [
        'img'=>'/sites/default/files/images/carousel/delicate-arch-3-1391955.jpg',
        'title'=>'ФИРМЕННЫЙ ТУР <br/>КАЛИФОРНИЯ - НЕВАДА - АРИЗОНА - ЮТА',
        'text'=>[
          '<i class="font-weight-bold">Тур 10 дней</i>. Самая полная программа по 4 штатам (California, Nevada, Arizona, Utah) - города и природа. Лос-Анжелес, Голливуд, Сан-Франциско, Сан-Диего, дневной и вечерний Лас Вегас.',
          'Музей Гетти. Чудеса природы - National Parks: Иосемитский заповедник (Iosemity)*, Гранд Каньон, Каньон Брайс (Brice Canyon), Зайон заповедник (Zion Canyon). К туру можно присоединиться из разных городов. Возможны сокращенные варианты тура - 7 или 5 дней'
        ],
        'button'=>[
          'link'=>'/regular/california',
          'text'=>'Russian tours in California'
        ]
      ],
      [
        'img'=>'/sites/default/files/images/carousel/downtown-tampa-florida-10-1214800.jpg',
        'title'=>'ФЛОРИДА. НАШ ТРАДИЦИОННЫЙ ФИРМЕННЫЙ ТУР.',
        'text'=>[
          'Автобусом, в сопровождении русского гида или тур с перелетом (7-9 дней). Проезд по 10 штатам Америки; города солнечной Флориды; музей Дали*; знаменитые Диснеевские парки* (Disney World*) и золотые пляжи. Орландо (Orlando), Майами-Бич (Miami), Тампа, Сен-Питерсбург, Дайтона-Бич, Ки-Вест, Сент-Огустин и другие города включены в различные программы наших туров',
          'Особенно популярны Новогодние туры во Флориду. Возможен тур с круизом. Предлагаем современный транспорт, комфортабельные гостиницы, сопровождение лучшими русскими гидами.'
        ],
        'button'=>[
          'link'=>'/regular/florida',
          'text'=>'Russian tours in Florida'
        ]
      ],
      [
        'img'=>'/sites/default/files/images/newyork/20150802_131104.jpg',
        'title'=>'ЕЖЕДНЕВНЫЙ ТУР по НЬЮ ЙОРКУ (New York)',
        'text'=>[
          'Во время экскурсии туристы знакомятся с площадью Times Square, Театральным Кварталом, посещают ООН, Рокфеллер-центр. Ненадолго заглянув в China Town (Китайский район) и Little Italy («Маленькая Италия»), туристы попадут в Даунтаун, к набережной и Южному Морскому Порту. Затем посещение финансового района, где расположено знаменитое здание Фондовой Биржи. Проехав по знаменитой Уолл-стрит (Wall Street), мы попадаем в Баттери-Парк (Battery Park), откуда открывается вид на символ страны – статую Свободы*.',
          'Есть программы с посещением Новогоднего зоопарка и Ботанического сада. Продолжительность тура - 8 часов. В стоимость тура включён ланч в ресторане.'
        ],
        'button'=>[
          'link'=>'/regular/newyork',
          'text'=>'Russian tours in New York'
        ]
      ],
      [
        'img'=>'/sites/default/files/images/carousel/old-montreal-1561322.jpg',
        'title'=>'ВСЯ КАНАДА',
        'text'=>[
          'Автобусные туры от 3-х до 6 дней. Города и природа Канады необыкновенно красивы: "фестиваль огней" на Ниагарских Водопадах, великолепие Монреаля, особая торжественность Оттавы, праздничный дух Торонто, как всегда, напоминающий ожившую сказку Квебек, радует горный фешенебельный курорт в горах Лаурентидах. Французская и Английская Канада. Район Тысяча Островов.',
          ''
        ],
        'button'=>[
          'link'=>'/regular/canada',
          'text'=>'Russian tours in Canada'
        ]
      ],
    ];
    // Main Info about
    $mainInfo = [
      //'bg_image'=>'/sites/default/files/images/carousel/world_small.png',
      'bg_image'=>'/sites/default/files/images/philadelphia/philadelphia-museum-of-art-1224654.jpg',
      'title'=>'О компании New Tours',
      'subtitle'=>'',
      'text'=>'<b>Компания New Tours</b>
            уже более 30 лет радует своих клиентов отменным сервисом, и в то же время наиболее доступными ценами.
            Наша компания New Tours ежегодно предлагает самую разнообразную программу экскурсий и отдыха.
            На любой вкус. На любой бюджет. На любой возраст. Для больших групп и одиночек.
            И всегда это с наивысшим комфортом, интереснейшими экскурсиями и квалифицированными гидами New Tours,
            которые сделают Ваш отдых наиболее приятным и запоминающимся.
            Приоритетным направлением компании являются групповые туры с русскоговорящими профессиональными гидами по США,
            Канаде и всему миру.',
      'text1'=>'Наиболее популярные маршруты: ежедневные обзорные экскурсии по',
      'text3'=> [
        '<a  href="/new-tours/regular/new-york" title="russian tour in New York.Russian tours in USA">
                    Нью Йорку,
        </a>',
        '<a  href="/new-tours/regular/one-day"  title="russian tour in Philadelphia, Dupon Gardens.Russian tours in USA">
      Филадельфия,
                </a>',
                '<a  href="/new-tours/regular/washington"  title="russian tour in Washington.Russian tours in USA">
      Вашингтону,
                </a>',
                '<a  href="/regular/boston" title="russian tour in Boston. Russian tours in USA">
      Бостону,
                </a>',
       '<a  href="/regular/niagara" title="russian tour in Niagara Falls. Russian tours in USA">
      Ниагарские Водопады,
                </a>',
      '<a  href="/regular/florida"  title="russian tour in Florida. Russian tours in USA">
      Флорида</a>,',
      '<a  href="/regular/california"  title="russian speaking tours in California. Russian tours in USA">
      Калифорния,</a>',
                '<a  href="/regular/california_7days" title="russian speaking tours in Las Vegas. Russian tours in USA">
      Лас-Вегас</a>',
                '<a  href="/regular/orlean-south" title="russian speaking tours in New Orlean. Russian tours in USA">
      Новый Орлеан</a>,',
    'туры от 3х до 6 дней в
    <a  href="/regular/canada" title="russian speaking tours in Canada. Russian tours in USA">
      Канаду,</a>',
    '<a  href="/regular/alaska" title="russian speaking tours in Alaska. Russian tours in USA">
      туры на Аляску,
      </a>',
        '<a  href="/regular/orlean-south" title="russian speaking tours in Alaska. Russian tours in USA">
       по Национальным паркам США,
      </a>',
        '<a  href="/regular/colorado-utah-yellowstone" title="russian speaking tours in Alaska. Russian tours in USA">
        Йеллоустоун,
      </a>',
    'а также специальная серия комлексных туров
    <a  href="/stars/">Звезды Атлантики,</a>
    в которых можно сочетать групповые туры с индивидуальными пожеланиями туристов.',
        ]
    ];

    $build = [
      '#theme' => 'main_page_default',
      '#image_source'=> '',
      '#images'=>'',
      '#topcard'=>$topCard,
      '#central_content'=>$centralContent,
      '#main_info_content'=>$mainInfo,
      '#attached' => [
        'library' => [
          //'tours/respTable',
          //'tours/main-carousel',
          'tours/owl-carousel',
          //'core/drupal.dialog.ajax'
        ],
        'drupalSettings' => [
          'tourData' => 'test',
        ]
      ],
    ];
    return $build;

  }

}
