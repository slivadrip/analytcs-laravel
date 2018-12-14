<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Analytics;
use Spatie\Analytics\Period;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



	public function index(){
		$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));

//retrieve visitors and pageviews since the 6 months ago
		$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::months(6));

//retrieve sessions and pageviews with yearMonth dimension since 1 year ago 
		$analyticsData = Analytics::performQuery(
			Period::years(1),
			'ga:sessions',
			[
				'metrics' => 'ga:sessions, ga:pageviews',
				'dimensions' => 'ga:yearMonth'
			]
		);


		//Recuperar as Páginas Mais Visitadas
		$pages = Analytics::fetchMostVisitedPages(Period::days(1));

		//recuperar visitantes e dados de visualização de página para o dia atual e os últimos quinze dias
		$visitors = Analytics::fetchVisitorsAndPageViews(Period::days(150));

		// Recuperar Total de Visitantes e Visualizações de Página
		$total_visitors = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));

		// Recuperar os principais referenciadores
		$top_referrers = Analytics::fetchTopReferrers(Period::days(7));

		// Recuperar Tipos de Usuários
		$user_types = Analytics::fetchUserTypes(Period::days(70));

		//Recuperar os principais navegadores
		$top_browser = Analytics::fetchTopBrowsers(Period::days(7));

		//Recuperar sessões e exibições de página com dimensão "yearMonth" desde 1 ano atrás
		$analyticsData = Analytics::performQuery(
			Period::years(1),
			'ga:sessions',
			[
				'metrics' => 'ga:sessions, ga:pageviews',
				'dimensions' => 'ga:yearMonth'
			]
		);

		//dd($visitors);
		foreach ($visitors as $v){
			echo $v['pageTitle'];
			echo $v['visitors'];
			echo $v['pageViews'];
			echo $v['date'];
			echo "<br>";

		}


	} 
	

}
