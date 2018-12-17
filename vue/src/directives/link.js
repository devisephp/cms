export default function(el, binding, vnode) {
  let link = binding.value;

  el.href = link.href;
  el.target = link.target;
}
