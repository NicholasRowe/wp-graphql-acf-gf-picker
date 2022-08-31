
References:
https://github.com/DannyvanHolten/acf-ninjaforms-add-on/blob/master/resources/Field.php
https://github.com/harness-software/wp-graphql-gravity-forms/blob/develop/docs/recipes/register-form-to-custom-field.md

Ensure that you set up the GF ACF Picker name to have a name value of "gf_acf_picker" otherwise the GraphQL schema will not recognise this block value.

![alt text](https://i.ibb.co/wMYFwr7/image.png)

And then query the graphl like so:

![alt text](https://i.ibb.co/Tq7Qj2C/image.png)
