<!DOCTYPE html>

<html lang="jp">
	<head>
		<title>プラン子</title>
		<meta charset="utf-8"/>
		<style>
			body{
				text-align: center;
				background-color: #000000;
			}
            h1 {
            	color: red;
            	font-size: 3em;
            }
            .delete_button {
				display       : inline-block;
				border-radius : 5%;          /* 角丸       */
				font-size     : 9pt;        /* 文字サイズ */
				text-align    : center;      /* 文字位置   */
				cursor        : pointer;     /* カーソル   */
				padding       : 12px 12px;   /* 余白       */
				background    : #6666ff;     /* 背景色     */
				color         : #ffffff;     /* 文字色     */
				line-height   : 1em;         /* 1行の高さ  */
				transition    : .3s;         /* なめらか変化 */
				border        : 2px solid #6666ff;    /* 枠の指定 */
			}
			.delete_button:hover {
				box-shadow    : none;        /* カーソル時の影消去 */
				color         : #6666ff;     /* 背景色     */
				background    : #ff0000;     /* 文字色     */
			}

			.button {
				display       : inline-block;
				border-radius : 5%;          /* 角丸       */
				font-size     : 9pt;        /* 文字サイズ */
				text-align    : center;      /* 文字位置   */
				cursor        : pointer;     /* カーソル   */
				padding       : 12px 12px;   /* 余白       */
				background    : #6666ff;     /* 背景色     */
				color         : #ffffff;     /* 文字色     */
				line-height   : 1em;         /* 1行の高さ  */
				transition    : .3s;         /* なめらか変化 */
				border        : 2px solid #6666ff;    /* 枠の指定 */
			}
			.button:hover {
				box-shadow    : none;        /* カーソル時の影消去 */
				color         : #6666ff;     /* 背景色     */
				background    : #ffffff;     /* 文字色     */
			}
			.button_form{
				flex: inline;
			}
        </style>
	</head>
	
	<body>
		<h1>警告！！<h1>
		<h1>
			本当に退会してしまいますか？<br>
			この操作は取り消せません！！
		</h1>
		<form action="/withdrawal" method="post" class="button_form"> 
            @csrf
			<input type="submit" class="delete_button" value="退会する" />
			<input type="submit" class="button" value="戻る" form="back_button"/>
		</form>
		
		<form action="/user/config" method="get" class="button_form" id="back_button">@csrf</form>
	<body>
</html>