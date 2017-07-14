/**
 * The internal dependencies.
 */
import { registerFieldComponent } from 'lib/registry';
import Select2Field from 'components/field';
import 'select2';
import css from 'select2/dist/css/select2.css';

registerFieldComponent('select2', Select2Field);
