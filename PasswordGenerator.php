<?php
class PasswordGenerator {
	private $words;
	private $median_word_length;

	function __construct($words_file)
	{
		$words = array_map('trim', file($words_file));
		$this->avarage_word_length = array_sum(array_map('strlen', $words)) / count($words);
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
	function obfuscate( $passphrase )
	{
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

	function phrase( $words_count = 3 )
	{
		shuffle($this->words);
		$attempt = 0;

		do {
			$random_words = array_slice($this->words, $attempt * $words_count, $words_count);
			$random_words = array_map('ucfirst', $random_words);
			$passphrase = implode('', $random_words);
			$attempt++;
		} while(strlen($passphrase) > $words_count * $this->avarage_word_length);

		return $passphrase;
	}

	function phrase_with_special_characters($words_count = 3)
	{
		return $this->obfuscate( $this->phrase($words_count) );
	}

}

