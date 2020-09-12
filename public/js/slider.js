class sliderClass {
    constructor() {
      this.slideChange = document.querySelector('div .welcome-msg-slider');
     
      this.timer = null;
      this.textNumber = 0;
      
      this.slidertext = [
        "<p><strong>Post-Scriptum</strong> pour créer une annonce vous devez être inscrit !</p>",
        "<p><strong>Bonjour</strong><br /> et bienvenue sur PaddleRent,</p>",
        "<p>Vous connaissez <strong>Leboncoin</strong>?</p>",
        "<p> Bah ici c'est pareil mais on y loue des paddles.</p>",
        "<p> Je vais pas décrire le site... du coup je vous laisse découvrir par vous même...</p>",
        "<p>Juste, pour info: sur la carte il y a tous les shops dispos pour de la loc' sur Annecy</p>",
      ];
     
      this.move();
      this.slideAutoStop();
    };
  
    move() {
      this.timeLine = document.getElementById("timeline");
      this.width = 1;
      this.id = setInterval(function () {
        if (this.width >= 100) {
          clearInterval(this.id);
        } else {
          this.width++;
          this.timeLine.style.width = this.width + "%";
        }
      }.bind(this), 50);
    }
  
    slideAutoStop() {
        this.timer = setInterval(this.nextImg.bind(this), 100);
        console.log(this.timer)
      }

  
    prevImg() {
      this.textNumber--;
      clearInterval(this.id);
      clearInterval(this.timer);
      this.timer = setInterval(this.nextImg.bind(this), 5000);
      this.move();
      if (this.textNumber < 0) {
        this.textNumber = this.slidertext.length - 1;
      }

      document.getElementById('text').innerHTML = this.slidertext[this.textNumber];
    }
  
    nextImg() {
      this.textNumber++;
      clearInterval(this.id);
      clearInterval(this.timer);
      this.timer = setInterval(this.nextImg.bind(this), 5000);
      this.move();
      if (this.textNumber > (this.slidertext.length - 1)) {
        this.textNumber = 0;
      }
      document.getElementById('text').innerHTML = this.slidertext[this.textNumber];
    }
  }
  
let sliderVelos = new sliderClass();