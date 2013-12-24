##FAQ Manager
FAQ Manager is an Extra for MODx Revolution that helps you manage your FAQs from within the Revo backend.

You can organize your Answers and Questions in sets and output them using a simple snippet call adding your own custom templates, CSS & JS.

## Getting started

Install however you please, but using the Revo package manager is encouraged.

Creating your first FAQs

After installing the package, you will find the FAQ Manager in the Components-Menu.

Before adding your first question, you need to create a FAQ set. After doing so, right click on the set to "Manage FAQ set".

Here you can add as many question/answer-pairs as you like.

The button in the upper-right corner brings you back to the set overview.

***
## FAQ Templates

The templates are divided into two parts, the set heading (setTpl) and the questions/answers (tpl).

### setTpl
To add headings to each set of FAQs, you will want to define this template. The template variables available in this template are:

- [[+id]]
- [[+name]]
- [[+description]]

The default template for this looks like this.

    <h2>
        [[+name]]
        <div>[[+description]]</div>
    </h2>

### tpl
The question/answer section template includes these placeholders

- [[+id]]
- [[+question]]
- [[+answer]]
- [[+rank]]
- [[+set]]

The default template for this section looks like this

    <div class="faqman-question">[[+question]]</div>
    <span class="faqman-answer">[[+answer]]</span>


##FAQ Snippet call

To output your FAQs, just place following snippet call in desired location:

    [[faqman]]

Calling it like this will output all FAQ sets and their questions. A more specific call would be like this:

    [[faqman?
      &set=`3`
      &tpl=`tpl`
      &setTpl=`setTpl`
    ]]

##Options

There are more options available to modify the call to your needs:

---

**set**             ID-value of FAQ set and lets you choose which FAQ set to display (if this is not specified ALL FAQ's will be displayed)

**tpl**             Name of the chunk to display your Questions/Answers

**setTpl**     Name of the chunk to display your FAQ set info

**sortBy**          This allows you to choose which field to sort by (default is rank).  _NOTE: If you do not define the FAQ set to display, all FAQs will be shown. The sets are not currently orderable, only the FAQs inside each set._

**sortDir**         ASC / DESC

**outputSeparator**	Separate each question/answer-pair by given string.

**setOutputSeparator** Separate each FAQ set with the given string.


---

A more complex call would look like this:

    [[faqman?
      &set=`1`
      &tpl=`faq_tpl`
      &sortBy=`rank`
      &sortDir=`ASC`
      &limit=`10`
      &outputSeparator=`<hr>`
    ]]

***

## Copyright Information

Thanks to Niklas (https://github.com/nklsf) for revamping the instructions for me!

faqMan is distributed as GPL (as MODx Revolution is). faqMan was built using the
handy modExtra (https://github.com/splittingred/modExtra)
created by splittingred(Shaun McCormick).