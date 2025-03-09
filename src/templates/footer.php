<?php 

use partials\FooterPartial;

?>  

<footer class="font-sans tracking-wide bg-gray-100 dark:bg-gray-800 dark:text-white px-10 pt-12 pb-6">
      <div class="flex flex-wrap justify-between gap-10">
        <div class="max-w-md">
          <a href='/' class="font-bold text-2xl">Avaris</a>
          <div class="mt-6">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-sm">Avaris is an easy way to manage all of your purchases and debts.</p>
          </div>
        </div>

       <?php 
          # Services Submenu
          echo FooterPartial::render_submenus(
            array(
              "header" => "Services",
              "links" => array(
                array(
                  "text"  => "Web Development",
                  "url"   => "#"
                ),
                array(
                  "text"  => "Pricing",
                  "url"   => "#"
                ),
                array(
                  "text"  => "Support",
                  "url"   => "#"
                ),
                array(
                  "text"  => "Client Portal",
                  "url"   => "#"
                ),
                array(
                  "text"  => "Resources",
                  "url"   => "#"
                ),
              )
            ));

          # Company
           echo FooterPartial::render_submenus(
            array(
              "header" => "Company",
              "links" => array(
                array(
                  "text"  => "About Us",
                  "url"   => "/about-us.php"
                ),
                array(
                  "text"  => "Careers",
                  "url"   => "/careers.php"
                ),
                array(
                  "text"  => "Blog",
                  "url"   => "/blog.php"
                ),
                array(
                  "text"  => "Portfolio",
                  "url"   => "/portfolio.php"
                ),
                array(
                  "text"  => "Events",
                  "url"   => "/events.php"
                )
              )
            ));

          # Company
           echo FooterPartial::render_submenus(
            array(
              "header" => "Resources",
              "links" => array(
                array(
                  "text"  => "FAQs",
                  "url"   => "/faqs.php"
                ),
                array(
                  "text"  => "Credits",
                  "url"   => "/credits.php"
                ),
                array(
                  "text"  => "Sitemap",
                  "url"   => "#"
                ),
                array(
                  "text"  => "Contact",
                  "url"   => "/contact.php"
                ),
                array(
                  "text"  => "News",
                  "url"   => "#"
                )
              )
            ));
       ?>
      </div>

      <hr class="mt-10 mb-6 border-gray-300" />

      <div class="flex flex-wrap max-md:flex-col gap-4">
        <?php 
        echo FooterPartial::render_lower_menus(array(
          array( "text" => "Privacy Notice", "url" => "#" ),
          array( "text" => "Cookie Policy", "url" => "#" ),
          array( "text" => "Security", "url" => "#" ),
        ));
        ?>        
        <p class='text-gray-600 dark:text-gray-300 text-sm md:ml-auto'>Created by <a href="https://hozay.tech/" class="underline underline-offset-8">Jose Manuel Chavez</a></p>
      </div>
    </footer>
