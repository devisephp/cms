import Vue from 'vue'
import { TweenMax, CSSPlugin } from 'gsap'
const plugins = [CSSPlugin]; 

export default {
  inserted: function (el) {
    let offset = 30
    var goHide = null

    let style = window.getComputedStyle ? getComputedStyle(el, null) : el.currentStyle;

    let marginLeft = parseInt(style.marginLeft) || 0;
    let marginRight = parseInt(style.marginRight) || 0;
    let marginTop = parseInt(style.marginTop) || 0;
    let marginBottom = parseInt(style.marginBottom) || 0;

    let elX = el.offsetLeft - marginLeft
    let elY = el.offsetTop - marginTop

    let elWidth = el.offsetWidth
    let elHeight = el.offsetHeight

    function calculateTuckX () {
      let rightSide = elX + elWidth + marginLeft + marginRight
      let leftSide = elX
      let halfWindow = window.innerWidth / 2

      if (rightSide - halfWindow > halfWindow - leftSide) {
        return window.innerWidth - offset - marginLeft
      }
      
      return - elWidth + offset
    }

    function calculateTuckY () {
      let topSide = elY + elHeight
      let bottomSide = elY
      let halfWindow = window.innerHeight / 2

      if (topSide - halfWindow > halfWindow - bottomSide) {
        return window.innerHeight - offset
      }
      
      return -elHeight + offset
    }

    function hide () {
      let tuckY = calculateTuckY()
      let tuckX = calculateTuckX()

      goHide = setTimeout(() => {
        TweenMax.to(el, 1, {
          top: `${tuckY}px`,
          left: `${tuckX}px`,
          width: `${elWidth}px`,
          height: `${elHeight}px`,
          ease: Elastic.easeOut.config(1, 0.5)
        })
      }, 3000)
    }

    function show () {
      clearTimeout(goHide)
      TweenMax.to(el, 1, {
        top: `${elY}px`,
        left: `${elX}px`,
        ease: Elastic.easeOut.config(1, 0.5)
      })
    }

    hide()

    el.addEventListener('mouseenter', show)
    el.addEventListener('mouseleave', hide)
  }
}
