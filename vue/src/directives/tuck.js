import Vue from 'vue'
import { TweenMax, CSSPlugin } from 'gsap'
const plugins = [CSSPlugin]; 

export default {
  inserted: function (el) {
    let offset = 50
    var goHide = null

    let style = window.getComputedStyle ? getComputedStyle(el, null) : el.currentStyle;

    let marginLeft = parseInt(style.marginLeft) || 0;
    let marginRight = parseInt(style.marginRight) || 0;
    let marginTop = parseInt(style.marginTop) || 0;
    let marginBottom = parseInt(style.marginBottom) || 0;

    let elX = el.offsetLeft - marginLeft
    let elY = el.offsetTop - marginTop

    var elWidth = el.offsetWidth
    var elHeight = el.offsetHeight

    function calculateTuckX () {
      let rightSide = elX + elWidth + marginLeft + marginRight
      let leftSide = elX
      let halfWindow = window.innerWidth / 2

      if (rightSide - halfWindow > halfWindow - leftSide) {
        return window.innerWidth - offset - marginLeft
      }
      
      return - elWidth + offset
    }

    function hide () {
      elWidth = el.offsetWidth
      elHeight = el.offsetHeight
      
      let tuckX = calculateTuckX()
      

      goHide = setTimeout(() => {
        TweenMax.to(el, 1, {
          left: `${tuckX}px`,
          width: `${elWidth}px`,
          height: `${elHeight}px`,
          ease: Elastic.easeOut.config(0.5, 0.5)
        })
      }, 1500)
    }

    function show () {
      clearTimeout(goHide)
      TweenMax.to(el, 1, {
        top: `${elY}px`,
        left: `${elX}px`,
        width: 'auto',
        ease: Elastic.easeOut.config(0.5, 0.5)
      })
    }

    hide()

    el.addEventListener('mouseenter', show)
    el.addEventListener('mouseleave', hide)
  }
}
