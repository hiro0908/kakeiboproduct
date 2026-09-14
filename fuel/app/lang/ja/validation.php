<?php
/**
 * fuel/core/lang/en/validation.php の日本語版。
 * アプリの config.php で language => 'ja' を指定すると、こちらが優先して読み込まれる。
 */

return array(
	'required'          => ':label は必須項目です。',
	'min_length'        => ':label は :param:1 文字以上で入力してください。',
	'max_length'        => ':label は :param:1 文字以内で入力してください。',
	'exact_length'      => ':label は :param:1 文字で入力してください。',
	'match_value'       => ':label には :param:1 を入力してください。',
	'match_pattern'     => ':label の形式が正しくありません。',
	'match_field'       => ':label は :param:1 と一致させてください。',
	'valid_email'       => ':label には正しいメールアドレスを入力してください。',
	'valid_emails'      => ':label には正しいメールアドレスのリストを入力してください。',
	'valid_url'         => ':label には正しいURLを入力してください。',
	'valid_ip'          => ':label には正しいIPアドレスを入力してください。',
	'numeric_min'       => ':label は :param:1 以上の数値を入力してください。',
	'numeric_max'       => ':label は :param:1 以下の数値を入力してください。',
	'numeric_between'   => ':label は :param:1 から :param:2 の間の数値を入力してください。',
	'valid_string'      => ':label の文字列チェック（:rule）に失敗しました。',
	'required_with'     => ':param:1 が入力されている場合、:label も入力してください。',
	'valid_date'        => ':label には正しい形式の日付を入力してください。',
	'match_collection'  => ':label は指定された選択肢の中から選んでください。',
);
