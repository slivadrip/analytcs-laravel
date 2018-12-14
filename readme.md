# Recuperar dados do Google Analytics

[![Latest Version](https://img.shields.io/github/release/spatie/laravel-analytics.svg?style=flat-square)](https://github.com/spatie/laravel-analytics/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-analytics/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-analytics)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-analytics.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-analytics)
[![StyleCI](https://styleci.io/repos/32067087/shield)](https://styleci.io/repos/32067087)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-analytics.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-analytics)

Usando este pacote, você pode recuperar facilmente dados do Google Analytics.

Aqui estão alguns exemplos dos métodos fornecidos:

```php
use Analytics;
use Spatie\Analytics\Period;

//buscar as páginas mais visitadas de hoje e da semana passada
Analytics::fetchMostVisitedPages(Period::days(7));

//Busque visitantes e visualizações de página da última semana
Analytics::fetchVisitorsAndPageViews(Period::days(7));
```

A maioria dos métodos retornará um `\Illuminate\Support\Collection` objeto contendo os resultados.


> **Se você estiver usando v1 deste pacote, consulte [uma versão mais antiga deste leia-me] (https://github.com/spatie/laravel-analytics/blob/88eb75beadcd8dade2f3ee2423f3716253b2104d/README.md) para o guia de instalação e uso ** **...

## Instalação

Este pacote pode ser instalado através do Composer.

``` bash
composer require spatie/laravel-analytics
```

No Laravel 5.5 e acima, o pacote autorizará o provedor de serviços. No Laravel 5.4 você deve instalar este provedor de serviços.

```php
// config/app.php
'providers' => [
    ...
    Spatie\Analytics\AnalyticsServiceProvider::class,
    ...
];
```

No Laravel 5.5 e acima, a embalagem autorizará a fachada. No Laravel 5.4 você deve instalar a fachada manualmente.

```php
// config/app.php
'aliases' => [
    ...
    'Analytics' => Spatie\Analytics\AnalyticsFacade::class,
    ...
];
```

Opcionalmente, você pode publicar o arquivo de configuração deste pacote com este comando:

``` bash
php artisan vendor:publish --provider="Spatie\Analytics\AnalyticsServiceProvider"
```

O seguinte arquivo de configuração será publicado em `config/analytics.php`

```php
return [

    /*
     * The view id of which you want to display data.
     */
    'view_id' => env('ANALYTICS_VIEW_ID'),

    /*
     * Path to the client secret json file. Take a look at the README of this package
     * to learn how to get this file. You can also pass the credentials as an array 
     * instead of a file path.
     */
    'service_account_credentials_json' => storage_path('app/analytics/service-account-credentials.json'),

    /*
     * The amount of minutes the Google API responses will be cached.
     * If you set this to zero, the responses won't be cached at all.
     */
    'cache_lifetime_in_minutes' => 60 * 24,

    /*
     * Here you may configure the "store" that the underlying Google_Client will
     * use to store it's data.  You may also add extra parameters that will
     * be passed on setCacheConfig (see docs for google-api-php-client).
     *
     * Optional parameters: "lifetime", "prefix"
     */
    'cache' => [
        'store' => 'file',
    ],
];
```

## Como obter as credenciais para se comunicar com o Google Analytics

### Obtendo credenciais

A primeira coisa que você precisa fazer é obter algumas credenciais para usar as APIs do Google. Suponho que você já tenha criado uma Conta do Google e esteja conectado. Acesse o [site da API do Google] (https://console.developers.google.com/apis) e clique em "Selecionar um projeto" no cabeçalho.

![1](https://spatie.github.io/laravel-analytics/v2/1.jpg)

Em seguida, devemos especificar quais APIs o projeto pode consumir. Na lista de APIs disponíveis, clique em "API do Google Analytics". Na próxima tela, clique em "Ativar".

![2](https://spatie.github.io/laravel-analytics/v2/2.jpg)

Agora que você criou um projeto que tem acesso à API do Google Analytics, é hora de fazer o download de um arquivo com essas credenciais. Clique em "Credenciais" na barra lateral. Você desejará criar uma "chave da conta de serviço".

![3](https://spatie.github.io/laravel-analytics/v2/3.jpg)

Na próxima tela, você pode dar um nome à conta de serviço. Você pode nomear tudo o que quiser. No ID da conta de serviço, você verá um endereço de e-mail. Usaremos este endereço de e-mail mais adiante neste guia. Selecione "JSON" como o tipo de chave e clique em "Criar" para baixar o arquivo JSON.

![4](https://spatie.github.io/laravel-analytics/v2/4.jpg)

Salve o json dentro do seu projeto Laravel no local especificado na chave `service_account_credentials_json` do arquivo de configuração deste pacote. Como o arquivo json contém informações potencialmente confidenciais, não é recomendável enviá-lo ao seu repositório git.

### Concedendo permissões à sua propriedade do Google Analytics

Suponho que você já criou uma conta do Google Analytics no [site do Google Analytics] (https://analytics.google.com/analytics). Vá para "Gerenciamento de usuários" na seção "Administrador" da propriedade.

![5](https://spatie.github.io/laravel-analytics/v2/5.jpg)

Nesta tela você pode conceder acesso ao endereço de e-mail encontrado na chave `client_email` do arquivo json que você baixou na etapa anterior. O acesso somente leitura é suficiente.

![6](https://spatie.github.io/laravel-analytics/v2/6.jpg)

### Obtendo o ID da visualização

A última coisa que você precisa fazer é preencher o `view_id` no arquivo de configuração. Você pode obter o valor correto no [site do Google Analytics] (https://analytics.google.com/analytics). Vá para "Visualizar configuração" na seção "Administrador" da propriedade.

![7](https://spatie.github.io/laravel-analytics/v2/7.jpg)

Você precisará do "View ID" exibido lá.

![8](https://spatie.github.io/laravel-analytics/v2/8.jpg)

## Uso

Quando a instalação estiver concluída, você poderá recuperar facilmente os dados do Google Analytics. Quase todos os métodos retornarão uma instância `Illuminate\Support\Collection`-instância.


Aqui estão alguns exemplos usando períodos
```php
// recuperar visitantes e dados de visualização de página para o dia atual e os últimos sete dias
$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));

// recuperar visitantes e pageviews desde os 6 meses atrás
$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::months(6));

// recupera sessões e exibições de página com dimensão yearMonth desde 1 ano atrás
$analyticsData = Analytics::performQuery(
    Period::years(1),
    'ga:sessions',
    [
        'metrics' => 'ga:sessions, ga:pageviews',
        'dimensions' => 'ga:yearMonth'
    ]
);
```

`$ analyticsData` é uma` coleção` na qual cada item é uma matriz que contém as chaves `data`,` visitantes` e `pageViews`

Se você deseja ter mais controle sobre o período para o qual deseja buscar dados, você pode passar um `startDate` e um` endDate` para o objeto period.

```php
$startDate = Carbon::now()->subYear();
$endDate = Carbon::now();

Period::create($startDate, $endDate);
```

## Métodos Fornecidos

### Visitantes e pageviews

```php
public function fetchVisitorsAndPageViews(Period $period): Collection
```

A função retorna uma `Collection` na qual cada item é uma matriz que contém as chaves` date`, `visitors`,` pageTitle` e `pageViews`.

### Total de visitantes e exibições de página

```php
public function fetchTotalVisitorsAndPageViews(Period $period): Collection
```

A função retorna uma `Coleção` na qual cada item é uma matriz que contém as chaves` date`, `visitors` e` pageViews`.

### Páginas mais visitadas

```php
public function fetchMostVisitedPages(Period $period, int $maxResults = 20): Collection
```

A função retorna uma `coleção` na qual cada item é uma matriz que contém as chaves` url`, `pageTitle` e` pageViews`.

### Principais referenciadores

```php
public function fetchTopReferrers(Period $period, int $maxResults = 20): Collection
```

A função retorna uma `coleção` na qual cada item é uma matriz que contém as chaves` url` e `pageViews`.

### Tipos de Usuários

```php
public function fetchUserTypes(Period $period): Collection
```

A função retorna uma `Collection` na qual cada item é uma matriz que contém as chaves` type` e `sessions`.

### Principais navegadores

```php
public function fetchTopBrowsers(Period $period, int $maxResults = 10): Collection
```

A função retorna uma `coleção` na qual cada item é uma matriz que contém as chaves` browser` e `sessions`.

### Todas as outras consultas do Google Analytics

Para realizar todas as outras consultas no recurso do Google Analytics, use `performQuery`. A [API de relatórios principais do Google] (https://developers.google.com/analytics/devguides/reporting/core/v3/common-queries) fornece mais informações sobre quais métricas e dimensões podem ser usadas.

```php
public function performQuery(Period $period, string $metrics, array $others = [])
```

Você pode obter acesso ao objeto `Google_Service_Analytics` subjacente:

```php
Analytics::getAnalyticsService();
```

## Testing

Execute os testes com:

``` bash
vendor/bin/phpunit
```



## Creditos

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)
- Spatie (https://spatie.be/opensource).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.