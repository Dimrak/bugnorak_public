
      <section id="show__contact">
        <h2 class="circles">Contact information</h2>
        <div id="2show__contact-div">
          <?php foreach($this->contact as $key => $value): ?>
            <div id="show__contact-div">
              <h2 class="">
                <span class="grid-item-show" style="margin-right: 20px; padding:5px 15px; width:30%;"><?= ucfirst($key) . ': '?></span><?= $value ?>
              </h2>
            </div>
            <!-- <hr style="width: 50%"> -->
          <?php  endforeach ?>
        </div>
      </section>
      <div class="artboard">
        <div class="card">
          <div class="card__side card__side--back">
          <div class="card__cover">
            <h4 class="card__heading">
            <span class="card__heading-span"><?= $this->contact->name ?></span>
            </h4>
          </div>
          <div class="card__details">
            <ul>
              <?php foreach($this->contact as $key => $value): ?>
                <li><?= ucfirst($key) . ': '?><?= $value ?></li>
              <?php endforeach ?>
            </ul>
          </div>
          </div>
          <div class="card__side card__side--front">
          <div class="card__theme">
            <div class="card__theme-box">
            <p class="card__subject">Show</p>
            </div>
          </div>
          </div>
        </div>
      </div>

