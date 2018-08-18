import Vue from 'vue'
import { TweenMax, CSSPlugin } from 'gsap'
const plugins = [CSSPlugin]; 

export default {
  bind: function (panel, binding, vnode) {

    let panelContents = panel.querySelector('.dvs-panel-contents')
    let panelShine = panel.querySelector('.dvs-panel-shine')

    function setPanelShine() {
      panelShine.style.width = `${panelContents.offsetWidth}px`
      panelShine.style.height = `${panelContents.offsetHeight}px`
    }

    function focusPanel(scale, opacity, duration) {
      TweenMax.to(panelContents, duration, {
        scale: scale,
        opacity: opacity,
        ease: 'elastic'
      })
    }

    function tiltPanel(event) {

      let xStrength = getXStrength(event.clientY) 
      let yStrength = getYStrength(event.clientX)

      TweenMax.to(panelContents, 0.5, {
        rotateX: `${xStrength * 30}deg`,
        rotateY: `${yStrength * 30 * -1}deg`,
        perspective: '1000px',
        ease: 'elastic'
      })

      // anime({
      //   targets: panelContents,
      //   rotateX: `${xStrength * 30}deg`,
      //   rotateY: `${yStrength * 30 * -1}deg`,
      //   perspective: '1000px',
      //   translateZ: `1em`,
      //   duration: 500
      // });
    }

    function getYStrength (cx) {
      let panelWidth = panel.offsetWidth
      let distanceFromMiddle = cx - (panelWidth/2)
      return distanceFromMiddle / (panelWidth/2)
    }

    function getXStrength (cy) {
      let panelHeight = panel.offsetHeight
      let distanceFromMiddle = cy - (panelHeight/2)
      return distanceFromMiddle / panelHeight
    }

    setPanelShine()

    // Set the initial position of the panel
    focusPanel(0.9, 0.7, 0)

    function enterPanel() { focusPanel(1.0, 1, 0.2) };
    function moveOverPanel(event) { tiltPanel(event) };
    function leavePanel() { focusPanel(0.9, 0.7, 0.4) };

    panel.addEventListener('mouseenter', enterPanel, false);
    panel.addEventListener('mousemove', moveOverPanel, false);
    panel.addEventListener('mouseleave', leavePanel, false);
  }
}
