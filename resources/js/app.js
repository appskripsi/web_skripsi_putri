import "./bootstrap";
import jQuery from "jquery";
import swal from "sweetalert2";

import.meta.glob(["../img/**"]);

window.swal = swal;
window.$ = window.jQuery;
window.$ = jQuery;
