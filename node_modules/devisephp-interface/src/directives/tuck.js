import Vue from 'vue';
import { TweenMax, TimelineLite, CSSPlugin } from 'gsap';
const plugins = [CSSPlugin];

export default {
  inserted: function(el) {
    let offset = 5;

    let style = window.getComputedStyle ? getComputedStyle(el, null) : el.currentStyle;

    let marginLeft = parseInt(style.marginLeft) || 0;
    let marginRight = parseInt(style.marginRight) || 0;
    let marginTop = parseInt(style.marginTop) || 0;
    let marginBottom = parseInt(style.marginBottom) || 0;

    let elX = el.offsetLeft - marginLeft;
    let elY = el.offsetTop - marginTop;

    var elWidth = el.offsetWidth;
    var elHeight = el.offsetHeight;

    var blocker = document.createElement('div');
    blocker.classList.add('dvs-blocker');
    document.body.appendChild(blocker);

    function calculateTuckX() {
      let rightSide = elX + elWidth + marginLeft + marginRight;
      let leftSide = elX;
      let halfWindow = window.innerWidth / 2;

      if (rightSide - halfWindow > halfWindow - leftSide) {
        return window.innerWidth - offset - marginLeft;
      }

      return -elWidth + offset;
    }

    function hide() {
      elWidth = el.offsetWidth;
      elHeight = el.offsetHeight;

      let timeline = new TimelineLite();
      let tuckX = calculateTuckX();

      TweenMax.to(el, 1, {
        left: `${tuckX}px`,
        width: `${elWidth}px`,
        height: `${elHeight}px`,
        ease: Elastic.easeOut.config(0.5, 0.5)
      });

      timeline
        .to(blocker, 0.5, {
          opacity: 0,
          ease: Power3.easeIn
        })
        .to(blocker, 0, {
          top: `${window.innerHeight}px`
        });

      deviseSettings.$bus.$emit('devise-close-sidebar');
    }

    function show() {
      let timeline = new TimelineLite();

      // Kill the initial page hide if I mouse over
      clearTimeout(initTimeout);

      TweenMax.to(el, 1, {
        top: `${elY}px`,
        left: `${elX}px`,
        width: 'auto',
        ease: Elastic.easeOut.config(0.5, 0.5)
      });

      timeline
        .to(blocker, 0, {
          top: `0px`
        })
        .to(blocker, 0.5, {
          opacity: 0.3,
          ease: Power3.easeOut
        });
    }

    let initTimeout = setTimeout(() => {
      hide();
    }, 1500);

    el.addEventListener('mouseenter', show);
    blocker.addEventListener('click', hide);
  }
};
