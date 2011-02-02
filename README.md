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

################
###############

FAQ Tempates

For templating, create a new chunk and use the placeholders [[+question]] and [[+answer]] to output the FAQs.

For example

<h3 class="faq_question"><a href="#">[[+question]]</a></h3>
<div class="faq_answer"> [[+answer]]</div>

################
###############

FAQ Snippet call

To output your FAQs, just place following snippet call in desired location:

[[faqman?
  &tpl=`faq_tpl`
]]

################
###############

Options

You can use some more options to modify the call to your needs:

---

set             ID-value of FAQ set and lets you choose which FAQ set to display (if this is not specified ALL FAQ's will be displayed)

tpl             Name of the chunk to display your Questions/Answers

categoryTpl     Name of the chunk to display your Category Headings (*category headings are not yet implemented)

sortBy          This allows you to choose which field to sort by (default is rank)

sortDir         ASC / DESC

limit           Amount of Questions/Answers to display (default is to show all that are returned)

outputSeparator	Separate each question/answer-pair by given string.


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

## Copyright Information

Thanks to Niklas (https://github.com/nklsf) for revamping the instructions for me!

faqMan is distributed as GPL (as MODx Revolution is). faqMan was built using the
handy modExtra (https://github.com/splittingred/modExtra)
created by splittingred(Shaun McCormick).