<?php
  global $session;
  ob_start();
  $title = "Logout";

  if (is_post_request()) {
    $session->logout();
    h("/auth/login");
    die();
  }

?>
<section>
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        <img src="/images/logo.svg" width="400px">
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8 text-center">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Logout
              </h1>
              <form class="space-y-4 md:space-y-6 dark:text-white" action="./logout.php" method="POST">
                <p>Are you sure you want to logout?</p>
                <div class="flex justify-center">
                  <a href="/dashboard/"
                    class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                      No! Take me back! 
                  </a>

                  <button 
                    type="submit" 
                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                      Yes, Log Out
                  </button>
                </div>
              </form>
          </div>
      </div>
  </div>
</section>


<?php
  $content = ob_get_clean();
  
 require_once(ROOT . "src/templates/template.php"); 

?>
