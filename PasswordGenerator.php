<?php
class PasswordGenerator {
	private $words;
	private $median_word_length;

	static function median($array) {
		$count = count($array);

		$middle_index = floor($count / 2);

		sort($array, SORT_NUMERIC);

		$median = $array[$middle_index];

		if ($count % 2 == 0) {
			$median = ($median + $array[$middle_index - 1]) / 2;
		}

		return $median;
	}

	function __construct($words_file) {
		$words = array_map('trim', file($words_file));
		$this->medianWordLength = self::median(array_map('strlen', $words));
		$this->words = $words;
	}

	/**
	 * This function will: 
	 *  - change a few common letters with special characters
	 *  - add a digit at the end of the password
	 *
	 * This is not going to have big impact on the security of the password, but it will satisfy some 
	 * password strength meters
	 */
	function obfuscate( $passphrase ) {
		$rules = [
			'a' => '@',
			's' => '$',
			'i' => '!',
		];

		$new_passphrase = '';
		$obfuscated_characters_limit = 1;
		$obfuscated_characters_count = 0;

		$characters = str_split( $passphrase );

		foreach ($characters as $character) {
			$lowercase_character = strtolower($character);

			if (isset($rules[$lowercase_character]) && $obfuscated_characters_count < $obfuscated_characters_limit) {
				$new_passphrase .= $rules[$lowercase_character];
				unset($rules[$lowercase_character]);
				$obfuscated_characters_count++;
			} else {
				$new_passphrase .= $character;
			}
		}

		$new_passphrase .= mt_rand(1, 9);

		return $new_passphrase;
	}

	function generate( $wordsCount = 3, $obfuscate = false ) {
		shuffle($this->words);
		$attempt = 0;

		do {
			$randomWords = array_slice($this->words, $attempt * $wordsCount, $wordsCount);
			$randomWords = array_map('ucfirst', $randomWords);
			$passphrase = implode('', $randomWords);
			$attempt++;
		} while(strlen($passphrase) > $wordsCount * $this->medianWordLength);

		if ($obfuscate) {
			$passphrase = $this->obfuscate($passphrase);
		}

		return $passphrase;
	}

}

