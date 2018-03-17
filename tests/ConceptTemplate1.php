<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-autocomplete
 */

namespace Ceive\Data\Autocomplete\Tests;


class ConceptTemplate1{
	
	public function testA(){
		// todo Javascript package - text constructor
		// todo Javascript modifier components with constructors and attribute standart
		// todo AttributeContext and Autocomplete
		// todo MicroTemplate
		$value = 'В вашу мед карту \{} было добавленно {files::count[plural: "файл", "файла", "файлов"]}';
		$composition = [
			'В вашу мед карту {} ',
			[
				'attribute'     => 'files::count',
				'type'          => 'plural',
				'definition'    => [
					'behind'=> ["был добавлен", "было добавленно", "были добавленны"],
					'value' => [[1 => false], ['2,3,4' => 'несколько'], true],
					'ahead' => ['файл', 'файла', 'файлов'],
					
					[
						'case'      => 'value == 0',
						'result'    => 'ни один файл не был добавлен'
					],[
						'case'      => 'value == 1',
						'result'    => 'был добавлен файл'
					],[
						'case'      => 'value in [2,3,4]',
						'result'    => 'было добавленно несколько файлов'
					],[// todo micro template context: little context(little or single attributes choice)
						'case'      => 'value::last == 1',
						'result'    => 'был добавлен {value} файл'
					],[
						'case'      => 'value::last in [2,3,4]',
						'result'    => 'было добавленно {value} файлов'
					],[
						'case'      => 'value::last == 0 OR value::last in-range [5,9]',
						'result'    => 'было добавленно {value} файлов'
					]
				
				]
			],
			[],
			' Возможно это связанно с вашей недавней консультацией'
		];
		$input_value = 'В вашу мед карту {} {files::count[plural behind: "был добавлен", "было добавленно", "были добавленны"; value: false, "несколько", true; ahead: "файл", "файла", "файлов"; ]}';
		
		
		$html = <<<HTML

<div class="text-structure">

	<span class="plain">В вашу мед карту {} </span>
	<span class="enclosure">
		<span class="value">
			<span class="plural-empty">не были добавленны файлы</span>
		</span>
	
		<span class="value">
			<span class="plural-behind">был добавлен</span>
			<span class="plural-value">1</span>
			<span class="plural-ahead">файл</span>
		</span>
		
		<span class="value">
			<span class="plural-behind">было добавленно</span>
			<span class="plural-value">несколько</span>
			<span class="plural-ahead">файлов</span>
		</span>
		
		<span class="value">
			<span class="plural-behind">было добавленно</span>
			<span class="plural-value">6</span>
			<span class="plural-ahead">файлов</span>
		</span>
	</span>
	<br/>
	<span class="plain">Возможно это связанно с вашей недавней консультацией</span>
</div>

HTML;
		
		
		
	}
}


