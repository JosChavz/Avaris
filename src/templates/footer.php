<?php 

require_once(ROOT . "/src/partials/footer.php"); 
use partials\FooterPartial;

?>  

<footer class="font-sans tracking-wide bg-gray-100 dark:bg-gray-800 dark:text-white px-10 pt-12 pb-6">
      <div class="flex flex-wrap justify-between gap-10">
        <div class="max-w-md">
          <a href='/' class="font-bold text-2xl">Avaris</a>
          <div class="mt-6">
            <p class="text-gray-600 leading-relaxed text-sm">Avaris is an easy way to manage all of your purchases and debts.</p>
          </div>
        </div>

        <div class="max-lg:min-w-[140px]">
          <h4 class="text-gray-800 font-semibold text-base relative max-sm:cursor-pointer">Services</h4>

          <ul class="mt-6 space-y-4">
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Web Development</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Pricing</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Support</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Client Portal</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Resources</a>
            </li>
          </ul>
        </div>

        <div class="max-lg:min-w-[140px]">
          <h4 class="text-gray-800 font-semibold text-base relative max-sm:cursor-pointer">Platforms</h4>
          <ul class="space-y-4 mt-6">
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Hubspot</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Integration Services</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Marketing Glossar</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>UIPath</a>
            </li>
          </ul>
        </div>

        <?php 
          FooterPartial::render_submenus(array(
            array(
              "header" => "Services",
              "links" => array(
                "Web development" => "#",
                "Pricing"         => "#",
                "Support"         => "#",
                "Client Portal"   => "#",
                "Resources"       => "#"
              )
            )
          ));
        ?>

        <div class="max-lg:min-w-[140px]">
          <h4 class="text-gray-800 font-semibold text-base relative max-sm:cursor-pointer">Company</h4>

          <ul class="space-y-4 mt-6">
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>About us</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Careers</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Blog</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Portfolio</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Events</a>
            </li>
          </ul>
        </div>

        <div class="max-lg:min-w-[140px]">
          <h4 class="text-gray-800 font-semibold text-base relative max-sm:cursor-pointer">Additional</h4>

          <ul class="space-y-4 mt-6">
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>FAQ</a>
            </li>
            <li>
              <a href='/credits.php' class='hover:text-gray-800 text-gray-600 text-sm'>Credits</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Sitemap</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Contact</a>
            </li>
            <li>
              <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>News</a>
            </li>
          </ul>
        </div>
      </div>

      <hr class="mt-10 mb-6 border-gray-300" />

      <div class="flex flex-wrap max-md:flex-col gap-4">
        <ul class="md:flex md:space-x-6 max-md:space-y-2">
          <li>
            <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Terms of Service</a>
          </li>
          <li>
            <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Privacy Policy</a>
          </li>
          <li>
            <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Security</a>
          </li>
        </ul>

        <p class='text-gray-600 text-sm md:ml-auto'>Created by <a href="https://hozay.io/" class="underline underline-offset-8">Jose Manuel Chavez</a></p>
      </div>
    </footer>
