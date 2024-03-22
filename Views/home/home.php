<?php if (isset($_SESSION['error']) && !empty($_SESSION["error"])) : ?>
  <div class="alart alert-danger" role='alert'>
    <?php echo $_SESSION["error"];
    unset($_SESSION['error']); ?>
  </div>
<?php
elseif (isset($_SESSION['success']) && !empty($_SESSION["success"])) : ?>
  <div class="alert alert-success" role='alert'>
    <?php echo $_SESSION["success"];
    unset($_SESSION['success']); ?>
  </div>
<?php endif;

require_once ROOT . '/Views/inc/header.php';
?>
<div class="mt-3 mx-5 d-lg-flex d-xl-flex gap-5">
  <!-- CALENDAR -->
  <aside class="darkerbg border-radius-20 p-4 d-none d-md-flex d-lg-block justify-content-between">
    <p class="my-4"><a href="" id='year' class="text-dark underline-none">2024</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Jan</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Fev</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Mar</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Avr</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Mai</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Jui</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Juil</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Aou</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Sep</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Oct</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Nov</a></p>
    <p class="my-4"><a href="" class="text-dark underline-none">Dec</a></p>
  </aside>

  <main class="w-100 my-3">
    <!-- SUM BALANCE -->
    <section class="row justify-content-between">
      <div class="col-lg-3 col-md-6 col-sm-6 orangeRadiant border-radius-20 py-3 ps-3">
        <h6 class="colorOrange">Balance actuelle</h6>
        <!-- on vérifie que l'utilisateur a bien inséré un income -->
        <?php if (!empty($incomes)) :
          foreach ($incomes as $income) :
            // idem on verifie que l'utilisateur a bien une transaction
            if (!empty($transacs)) :
              foreach ($transacs as $transac) :
                // on verifie que les transactions et l'income appartienne bien à l'utilisateur
                if ($income->user_id && $transac->user_id == $_SESSION['user']['id']) : ?>
                  <!-- sinon on set à 0 -->
                  <h2 class="text-white"> <?= $income->total_amount - $transac->total_amount; ?> €</h2>

          <?php endif;
              endforeach;
            endif;
          endforeach;
        else : ?>
          <h2 class="text-white"> 0€</h2>
        <?php endif ?>
      </div>
      <a href="index?p=income/index" class="col-lg-2 col-md-6 col-sm-6 darkerbg border-radius-20 py-3 ps-3 underline-none">
        <h6 class="colorOther">Revenu</h6>

        <?php if (!empty($incomes)) :
          foreach ($incomes as $income) :
            if ($income->user_id == $_SESSION['user']['id']) : ?>
              <h2 class="text-dark"><?= $income->total_amount ?>€</h2>

          <?php endif;
          endforeach;
        else : ?>
          <h2 class="text-dark">0€</h2>
        <?php endif; ?>

      </a>
      <div class="col-lg-2 col-md-6 col-sm-6 darkerbg border-radius-20 py-3 ps-3">
        <h6 class="colorOther">Dépense</h6>
        <?php if (!empty($transacs)) :
          foreach ($transacs as $transac) :
            if ($transac->user_id == $_SESSION['user']['id']) : ?>
              <h2 class="text-dark"><?= $transac->total_amount ?>€</h2>

          <?php endif;
          endforeach;
        else : ?>
          <h2 class="text-dark">0€</h2>
        <?php endif; ?>
      </div>
      <a href="index?p=saving/index" class="col-lg-3 col-md-6 col-sm-6 greenRadient border-radius-20 py-3 ps-3 underline-none">
        <h6 class="colorGreen">Economie</h6>

        <?php if (!empty($savings)) :
          foreach ($savings as $saving) :
            if ($saving->user_id == $_SESSION['user']['id']) : ?>
              <h2 class="text-white"><?= $saving->total_amount ?>€</h2>

          <?php endif;
          endforeach;
        else : ?>
          <h2 class="text-white">0€</h2>
        <?php endif; ?>

      </a>
    </section>

    <section class='d-sm-block d-lg-flex  gap-4'>
      <!-- CATEGORIES -->
      <div class="d-none d-md-flex flex-md-column my-4 darkerbg border-radius-20 p-4">
        <h4 class="colorOther mb-5">Catégories</h4>
        <div class='d-none d-md-flex d-lg-block'>
          <?php foreach ($categories as $category) : ?>
            <article class="d-flex align-items-center my-3">
              <figure class="<?= strtolower($category->title); ?> border-radius-customized">
                <img src="assets/upload/categories_icon/<?= $category->icon; ?>" alt="<?= $category->title; ?>" class=" p-2 opacity-20" id="category-icon">
              </figure>
              <div class="d-flex flex-column mx-4">
                <p class="m-0 fs-6"><?= $category->title; ?></p>
                <?php $found = false; ?>
                <?php foreach ($transactions as $transaction) : ?>
                  <?php if ($transaction->user_id == $_SESSION['user']['id'] && $transaction->category_id == $category->id) : ?>
                    <p class="fs-3 m-0 text-md"><?= $transaction->total_amount ?> €</p>
                    <?php $found = true; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!$found) : ?>
                  <p class="fs-3 text-md">0 €</p>
                <?php endif; ?>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- TRANSACTIONS -->
      <div>
        <div class="m-3 d-sm-block d-lg-flex">
          <a href="index?p=transaction/read" class="underline-none darkerbg table-responsive p-2 border-radius-20 col-8">
            <table class=" table">
              <thead>
                <tr class="table-light">
                  <th scope="col">Titre</th>
                  <th scope="col">Montant</th>
                  <th scope="col">Lieu d'achat</th>
                  <th scope="col">Date</th>
                  <th scope="col">Catégorie</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($trcs as $trc) :
                  if ($trc->user_id == $_SESSION['user']['id']) :
                ?>

                    <tr class="table-light">
                      <td><?= $trc->title; ?></td>
                      <td><?= $trc->amount / $trc->payment_option; ?>€</td>
                      <td><?= $trc->location; ?></td>
                      <td><?= $trc->created_at; ?></td>
                      <td class='d-flex'>
                        <figure class="<?= strtolower($trc->category_title); ?> border-radius-customized">
                          <img src="assets/upload/categories_icon/<?= $trc->category_icon; ?>" alt="<?= $trc->category_title; ?>" class=" p-1 opacity-20" width="30">
                        </figure> <?= $trc->category_title; ?>
                      </td>                    </tr>
                <?php
                  endif;
                endforeach ?>
              </tbody>
            </table>
          </a>

          <a href="index?p=income/index" class="underline-none darkerbg border-radius-20 col-4 ms-4 p-3">
            <h4 class="colorOther mb-5">Type de revenus</h4>
            <canvas id="myChart" class="w-100 h-75 mb-3"></canvas>
          </a>
        </div>

        <!-- GOALS -->
        <a href="index?p=goal/index" class="m-3  border-radius-20 underline-none "> 
          <div class="border-radius-20 p-2 darkerbg">
          <h4 class="colorOther p-2">Objectifs</h4>

          <?php
          foreach ($goals as $goal) :
            if ($goal->user_id == $_SESSION['user']['id']):
            foreach ($savings as $saving) :
          ?>
              <p class="text-end text-black"> <?= $saving->total_amount . '€ / ' . $goal->amount; ?>€ </p>
              <div class="progress mx-3 mb-3">
                <div class="progress-bar orangeRadiant" role="progressbar" aria-valuenow="<?= ($saving->total_amount / $goal->amount) * 100; ?>" aria-valuemin="0" aria-valuemax="100"><?= $goal->title; ?></div>
              </div>
          <?php
            endforeach;
          endif; endforeach; ?>
          </div>
        </a>


      </div>
    </section>
  </main>
</div>
<?php require_once ROOT . '/Views/inc/footer.php'; ?>