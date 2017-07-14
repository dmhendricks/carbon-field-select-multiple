/**
 * The internal dependencies.
 */
import { registerFieldComponent } from 'lib/registry';
import SelectMultipleField from 'components/field';
import 'select2';
import css from 'select2/dist/css/select2.css';

registerFieldComponent('select_multiple', SelectMultipleField);
