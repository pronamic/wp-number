# Pronamic WordPress Number

WordPress Number library.

## Design Principles

### A number is a number

> In general, a number is a number, not a string, and this means that any programming language treats a number as a number. Thus, the number by itself doesn't imply any specific format (like using .000021 instead of 2.1e-5). This is nothing different to displaying a number with leading zeros (like 0.000021) or aligning lists of numbers. This is a general issue you'll find in any programming language: if you want a specific format you need to specify it, using the format functions of your programming language.
> 
> Unless you specify the number as string and convert it to a real number when needed, of course. Some languages can do this implicitly.

https://stackoverflow.com/a/1471792

### Number in exponential form / scientific notation

> 2.1E-5 is the same number as 0.000021. That's how it prints numbers below 0.001. Use printf() if you want it in a particular format.
> 
> **Edit** If you're not familiar with the `2.1E-5` syntax, you should know it is shorthand for 2.1×10-5. It is how most programming languages represent numbers in scientific notation.

https://stackoverflow.com/a/1471694
