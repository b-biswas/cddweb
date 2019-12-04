<h2 class="class_test">
	Comment coder en HTML - CSS - PHP
	<!-- Subtitle -->
<h2/>

<h3>
	Créer des paragraphes
</h3>
<p>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam lobortis facilisis sem. Nullam nec mi et neque pharetra sollicitudin. Praesent imperdiet mi nec ante. Donec ullamcorper, felis non sodales commodo, lectus velit ultrices augue, a dignissim nibh lectus placerat pede. Vivamus nunc nunc, molestie ut, ultricies vel, semper in, velit. Ut porttitor. Praesent in sapien. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis fringilla tristique neque. Sed interdum libero ut metus. Pellentesque placerat. Nam rutrum augue a leo. Morbi sed elit sit amet ante lobortis sollicitudin. Praesent blandit blandit mauris. Praesent lectus tellus, aliquet aliquam, luctus a, egestas a, turpis. Mauris lacinia lorem sit amet ipsum. Nunc quis urna dictum turpis accumsan semper.
</p>

<p>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam lobortis facilisis sem. Nullam nec mi et neque pharetra sollicitudin. Praesent imperdiet mi nec ante. Donec ullamcorper, felis non sodales commodo, lectus velit ultrices augue, a dignissim nibh lectus placerat pede. Vivamus nunc nunc, molestie ut, ultricies vel, semper in, velit. Ut porttitor. Praesent in sapien. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis fringilla tristique neque. Sed interdum libero ut metus. Pellentesque placerat. Nam rutrum augue a leo. Morbi sed elit sit amet ante lobortis sollicitudin. Praesent blandit blandit mauris. Praesent lectus tellus, aliquet aliquam, luctus a, egestas a, turpis. Mauris lacinia lorem sit amet ipsum. Nunc quis urna dictum turpis accumsan semper.
</p>

<!-- Can do this up to h7 -->
<h3>
	Différentes manières de mettre le texte en évidence :
</h3>

<p>
	<!-- Paragraph --> 
	<!-- Use a new paragraph to create a line break -->
	<!-- We can also use <br /> -->
	<em> texte mis en évidence. </em> <br/>
	<strong> text fort. </strong> <br/>
	<mark> texte marqué. </mark> <br/>
</p>

<p>
	Différents types de listes : <br/>
	<!-- Non ordered list -->
	<ul>
		<li>Item 1</li>
		<li>Item 2</li>
		<li>Item 3</li>
	</ul>
	<!-- Ordered list -->
	<ol>
		<li>Item 1</li>
		<li>Item 2</li>
		<li>Item 3</li>
	</ol>
<p/>	

<h3>
	Créer un lien
</h3>

<p>
	Lien simple :
	<a href="https://www.overleaf.com/">Overleaf</a> <br/>
	<!-- If the website contains symbols like &, they have to be replaced by &amp -->

	<!-- We can also create links with a relative path -->
	<!-- To create an anchor -->
	<!-- <h2 id="anchor_id">Titre</h2> -->
	<!-- <a href="#anchor_id"> Go to this anchor</a> -->
	<!--
		Anchor in another website, use the symbol #:
		<a href="ancres.html#anchor_id">
	-->
	Voici un lien <strong>avec une description</strong>: <a href="https://www.overleaf.com/" title="LaTeX editor">Overleaf avec une description</a> <br/>
	Lien s'ouvrant dans un <strong>nouvel onglet</strong>: <a href="https://www.overleaf.com/" title="LaTeX editor" target="_blank">Overleaf dans un nouvel onglet</a> <br/>
	Lien vers une <strong>adresse e-mail</strong>: <a href="mailto:gatelet@apc.in2p3.fr">Envoie-moi un e-mail!</a> <br/>
	Lien vers les informations sur le serveur PHP: <a href="php_info.php" target="_blank"> Information PHP</a> <br/>
						
<p/>

<h3>
	Ajouter une image : <br/>
</h3>

<!-- With this method, it is always inside a paragraph -->
<p>
	<!-- <img src="Images/CKM_triangle.png" alt="My triangle" title="Best triangle ever!" /> -->
	<!-- We can also print a small image on which we click to get the full size image. However, we need two images of different sizes to do so. -->
</p>
					

<figure>
	<!-- Not in a paragraph -->
	<!-- There can be several images inside a figure -->
	<img src="Images/CKM_triangle.png" alt="Bloc-Notes" />
	<figcaption>Ceci est la légende de l'image ci-dessus : triangle unitaire des paramètres de la matrice CKM.</figcaption>
</figure>

<p>
	Lien pour télécharger un fichier : <a href="Images/CKM_triangle.png">Download.</a> <br/>
	Ce lien permet de télécharger l'image ci-dessus.
</p>
