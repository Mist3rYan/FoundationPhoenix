<header>
  <nav class="px-4 navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="assets/images/logo.svg" width="50" height="50" alt="logo" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Foundation Phoenix</a>
          </li>
          <?php if (isset($_SESSION["user"])) { ?>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="pageMissions.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Missions
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="pageMissions.php">New</a></li>
                <li><a class="dropdown-item" href="#">Get</a></li>
                <li><a class="dropdown-item" href="#">Delete</a></li>
                <li><a class="dropdown-item" href="#">Modify</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="pageAgents.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Agents
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./pageAgentCreate.php">New</a></li>
                <li><a class="dropdown-item" href="./pageAgents.php">Get</a></li>
                <li><a class="dropdown-item" href="./pageAgentsDelete.php">Delete</a></li>
                <li><a class="dropdown-item" href="./pageAgentModify.php">Modify</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="pageTargets.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Targets
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./pageTargetCreate.php">New</a></li>
                <li><a class="dropdown-item" href="./pageTargets.php">Get</a></li>
                <li><a class="dropdown-item" href="./pageTargetsDelete.php">Delete</a></li>
                <li><a class="dropdown-item" href="#">Modify</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="pageContacts.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Contacts
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./pageContactCreate.php">New</a></li>
                <li><a class="dropdown-item" href="./pageContacts.php">Get</a></li>
                <li><a class="dropdown-item" href="./pageContactsDelete.php">Delete</a></li>
                <li><a class="dropdown-item" href="#">Modify</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="pageHideouts.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Hideouts
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./pageHideoutCreate.php">New</a></li>
                <li><a class="dropdown-item" href="./pageHideouts.php">Get</a></li>
                <li><a class="dropdown-item" href="./pageHideoutsDelete.php">Delete</a></li>
                <li><a class="dropdown-item" href="#">Modify</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="pageSpecialities.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Specialities
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./pageSpecialitieCreate.php">New</a></li>
                <li><a class="dropdown-item" href="./pageSpecialities.php">Get</a></li>
                <li><a class="dropdown-item" href="./pageSpecialitiesDelete.php">Delete</a></li>
              </ul>
            </li>
        </ul>
      </div>
      <a class="btn btn-danger" href="logout.php">Déconnexion</a>
    <?php } else { ?>
      <li class="nav-item active">
            <a class="nav-link" href="pageMissions.php">Missions</a>
          </li>
      </ul>
      </div>
      <a class="btn btn-primary" href="login.php">Connexion</a>
    <?php
          }
    ?>
    </div>
  </nav>
</header>