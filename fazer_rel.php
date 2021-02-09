<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <!-- Compiled and minified CSS and Import Google Icon Font -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
		<!-- Compiled and minified JavaScript -->
		<script type = "text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>

		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <style>
            article{
                height: 700px;
            }

        </style>
    </head>

    <body> 
        <div class="container">
            <article id="1">
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header">TEXTO 1</div>
                        <div class="collapsible-body"><span>CONTEUDO 1</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 2</div>
                        <div class="collapsible-body"><span>CONTEUDO 2</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 3</div>
                        <div class="collapsible-body"><span>CONTEUDO 3</span></div>
                    </li>
                </ul>
            </article>
        
            <article id="2">
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header">TEXTO 4</div>
                        <div class="collapsible-body"><span>CONTEUDO 4</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 5</div>
                        <div class="collapsible-body"><span>CONTEUDO 5</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 6</div>
                        <div class="collapsible-body"><span>CONTEUDO 6</span></div>
                    </li>
                </ul>
            </article>

            <article id="3">
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header">TEXTO 7</div>
                        <div class="collapsible-body"><span>CONTEUDO 7</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 8</div>
                        <div class="collapsible-body"><span>CONTEUDO 8</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 9</div>
                        <div class="collapsible-body"><span>CONTEUDO 9</span></div>
                    </li>
                </ul>
            </article>

            <article id="4">
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header">TEXTO 10</div>
                        <div class="collapsible-body"><span>CONTEUDO 10</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 11</div>
                        <div class="collapsible-body"><span>CONTEUDO 11</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 12</div>
                        <div class="collapsible-body"><span>CONTEUDO 12</span></div>
                    </li>
                </ul>
            </article>

            <article id="5">
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header">TEXTO 13</div>
                        <div class="collapsible-body"><span>CONTEUDO 13</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 14</div>
                        <div class="collapsible-body"><span>CONTEUDO 14</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 15</div>
                        <div class="collapsible-body"><span>CONTEUDO 15</span></div>
                    </li>
                </ul>
            </article>

            <article id="6">
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header">TEXTO 16</div>
                        <div class="collapsible-body"><span>CONTEUDO 16</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 17</div>
                        <div class="collapsible-body"><span>CONTEUDO 17</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 18</div>
                        <div class="collapsible-body"><span>CONTEUDO 18</span></div>
                    </li>
                </ul>
            </article>

            <article id="7">
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header">TEXTO 19</div>
                        <div class="collapsible-body"><span>CONTEUDO 19</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 20</div>
                        <div class="collapsible-body"><span>CONTEUDO 20</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header">TEXTO 21</div>
                        <div class="collapsible-body"><span>CONTEUDO 21</span></div>
                    </li>
                </ul>
            </article>
        </div>

        <script>
        $(document).ready(function(){
            $('.collapsible').collapsible({accordion: false});
        });
        </script>
    </body>   
</html>
