(function(root, builder) {
    root.ggmvc = builder(root, {}, (root.jQuery || root.Zepto || root.ender || root.$));
})(window, function(window, ggmvc, $) {

    var previousGgmvc = window.ggmvc;
    if (previousGgmvc)
        return previousGgmvc;
    ggmvc.VERSION = '1.0.0';
    ggmvc._ = {};

//     Underscore.js 1.6.0
//     http://underscorejs.org
//     (c) 2009-2014 Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
//     Underscore may be freely distributed under the MIT license.
    // Baseline setup
    // --------------

    // Establish the root object, `window` in the browser, or `exports` on the server.
    var root = this;

    // Save the previous value of the `_` variable.
    var previousUnderscore = root._;

    // Establish the object that gets returned to break out of a loop iteration.
    var breaker = {};

    // Save bytes in the minified (but not gzipped) version:
    var ArrayProto = Array.prototype, ObjProto = Object.prototype, FuncProto = Function.prototype;

    // Create quick reference variables for speed access to core prototypes.
    var
            push = ArrayProto.push,
            slice = ArrayProto.slice,
            concat = ArrayProto.concat,
            toString = ObjProto.toString,
            hasOwnProperty = ObjProto.hasOwnProperty;

    // All **ECMAScript 5** native function implementations that we hope to use
    // are declared here.
    var
            nativeForEach = ArrayProto.forEach,
            nativeMap = ArrayProto.map,
            nativeReduce = ArrayProto.reduce,
            nativeReduceRight = ArrayProto.reduceRight,
            nativeFilter = ArrayProto.filter,
            nativeEvery = ArrayProto.every,
            nativeSome = ArrayProto.some,
            nativeIndexOf = ArrayProto.indexOf,
            nativeLastIndexOf = ArrayProto.lastIndexOf,
            nativeIsArray = Array.isArray,
            nativeKeys = Object.keys,
            nativeBind = FuncProto.bind;

    // Create a safe reference to the Underscore object for use below.
    var _ = function(obj) {
        if (obj instanceof _)
            return obj;
        if (!(this instanceof _))
            return new _(obj);
        this._wrapped = obj;
    };

    // Export the Underscore object for **Node.js**, with
    // backwards-compatibility for the old `require()` API. If we're in
    // the browser, add `_` as a global object via a string identifier,
    // for Closure Compiler "advanced" mode.
    if (typeof exports !== 'undefined') {
        if (typeof module !== 'undefined' && module.exports) {
            exports = module.exports = _;
        }
        exports._ = _;
    } else {
        root._ = _;
    }

    // Current version.
    _.VERSION = '1.6.0';

    // Collection Functions
    // --------------------

    // The cornerstone, an `each` implementation, aka `forEach`.
    // Handles objects with the built-in `forEach`, arrays, and raw objects.
    // Delegates to **ECMAScript 5**'s native `forEach` if available.
    var each = _.each = _.forEach = function(obj, iterator, context) {
        if (obj == null)
            return obj;
        if (nativeForEach && obj.forEach === nativeForEach) {
            obj.forEach(iterator, context);
        } else if (obj.length === +obj.length) {
            for (var i = 0, length = obj.length; i < length; i++) {
                if (iterator.call(context, obj[i], i, obj) === breaker)
                    return;
            }
        } else {
            var keys = _.keys(obj);
            for (var i = 0, length = keys.length; i < length; i++) {
                if (iterator.call(context, obj[keys[i]], keys[i], obj) === breaker)
                    return;
            }
        }
        return obj;
    };

    // Return the results of applying the iterator to each element.
    // Delegates to **ECMAScript 5**'s native `map` if available.
    _.map = _.collect = function(obj, iterator, context) {
        var results = [];
        if (obj == null)
            return results;
        if (nativeMap && obj.map === nativeMap)
            return obj.map(iterator, context);
        each(obj, function(value, index, list) {
            results.push(iterator.call(context, value, index, list));
        });
        return results;
    };

    var reduceError = 'Reduce of empty array with no initial value';

    // **Reduce** builds up a single result from a list of values, aka `inject`,
    // or `foldl`. Delegates to **ECMAScript 5**'s native `reduce` if available.
    _.reduce = _.foldl = _.inject = function(obj, iterator, memo, context) {
        var initial = arguments.length > 2;
        if (obj == null)
            obj = [];
        if (nativeReduce && obj.reduce === nativeReduce) {
            if (context)
                iterator = _.bind(iterator, context);
            return initial ? obj.reduce(iterator, memo) : obj.reduce(iterator);
        }
        each(obj, function(value, index, list) {
            if (!initial) {
                memo = value;
                initial = true;
            } else {
                memo = iterator.call(context, memo, value, index, list);
            }
        });
        if (!initial)
            throw new TypeError(reduceError);
        return memo;
    };

    // The right-associative version of reduce, also known as `foldr`.
    // Delegates to **ECMAScript 5**'s native `reduceRight` if available.
    _.reduceRight = _.foldr = function(obj, iterator, memo, context) {
        var initial = arguments.length > 2;
        if (obj == null)
            obj = [];
        if (nativeReduceRight && obj.reduceRight === nativeReduceRight) {
            if (context)
                iterator = _.bind(iterator, context);
            return initial ? obj.reduceRight(iterator, memo) : obj.reduceRight(iterator);
        }
        var length = obj.length;
        if (length !== +length) {
            var keys = _.keys(obj);
            length = keys.length;
        }
        each(obj, function(value, index, list) {
            index = keys ? keys[--length] : --length;
            if (!initial) {
                memo = obj[index];
                initial = true;
            } else {
                memo = iterator.call(context, memo, obj[index], index, list);
            }
        });
        if (!initial)
            throw new TypeError(reduceError);
        return memo;
    };

    // Return the first value which passes a truth test. Aliased as `detect`.
    _.find = _.detect = function(obj, predicate, context) {
        var result;
        any(obj, function(value, index, list) {
            if (predicate.call(context, value, index, list)) {
                result = value;
                return true;
            }
        });
        return result;
    };

    // Return all the elements that pass a truth test.
    // Delegates to **ECMAScript 5**'s native `filter` if available.
    // Aliased as `select`.
    _.filter = _.select = function(obj, predicate, context) {
        var results = [];
        if (obj == null)
            return results;
        if (nativeFilter && obj.filter === nativeFilter)
            return obj.filter(predicate, context);
        each(obj, function(value, index, list) {
            if (predicate.call(context, value, index, list))
                results.push(value);
        });
        return results;
    };

    // Return all the elements for which a truth test fails.
    _.reject = function(obj, predicate, context) {
        return _.filter(obj, function(value, index, list) {
            return !predicate.call(context, value, index, list);
        }, context);
    };

    // Determine whether all of the elements match a truth test.
    // Delegates to **ECMAScript 5**'s native `every` if available.
    // Aliased as `all`.
    _.every = _.all = function(obj, predicate, context) {
        predicate || (predicate = _.identity);
        var result = true;
        if (obj == null)
            return result;
        if (nativeEvery && obj.every === nativeEvery)
            return obj.every(predicate, context);
        each(obj, function(value, index, list) {
            if (!(result = result && predicate.call(context, value, index, list)))
                return breaker;
        });
        return !!result;
    };

    // Determine if at least one element in the object matches a truth test.
    // Delegates to **ECMAScript 5**'s native `some` if available.
    // Aliased as `any`.
    var any = _.some = _.any = function(obj, predicate, context) {
        predicate || (predicate = _.identity);
        var result = false;
        if (obj == null)
            return result;
        if (nativeSome && obj.some === nativeSome)
            return obj.some(predicate, context);
        each(obj, function(value, index, list) {
            if (result || (result = predicate.call(context, value, index, list)))
                return breaker;
        });
        return !!result;
    };

    // Determine if the array or object contains a given value (using `===`).
    // Aliased as `include`.
    _.contains = _.include = function(obj, target) {
        if (obj == null)
            return false;
        if (nativeIndexOf && obj.indexOf === nativeIndexOf)
            return obj.indexOf(target) != -1;
        return any(obj, function(value) {
            return value === target;
        });
    };

    // Invoke a method (with arguments) on every item in a collection.
    _.invoke = function(obj, method) {
        var args = slice.call(arguments, 2);
        var isFunc = _.isFunction(method);
        return _.map(obj, function(value) {
            return (isFunc ? method : value[method]).apply(value, args);
        });
    };

    // Convenience version of a common use case of `map`: fetching a property.
    _.pluck = function(obj, key) {
        return _.map(obj, _.property(key));
    };

    // Convenience version of a common use case of `filter`: selecting only objects
    // containing specific `key:value` pairs.
    _.where = function(obj, attrs) {
        return _.filter(obj, _.matches(attrs));
    };

    // Convenience version of a common use case of `find`: getting the first object
    // containing specific `key:value` pairs.
    _.findWhere = function(obj, attrs) {
        return _.find(obj, _.matches(attrs));
    };

    // Return the maximum element or (element-based computation).
    // Can't optimize arrays of integers longer than 65,535 elements.
    // See [WebKit Bug 80797](https://bugs.webkit.org/show_bug.cgi?id=80797)
    _.max = function(obj, iterator, context) {
        if (!iterator && _.isArray(obj) && obj[0] === +obj[0] && obj.length < 65535) {
            return Math.max.apply(Math, obj);
        }
        var result = -Infinity, lastComputed = -Infinity;
        each(obj, function(value, index, list) {
            var computed = iterator ? iterator.call(context, value, index, list) : value;
            if (computed > lastComputed) {
                result = value;
                lastComputed = computed;
            }
        });
        return result;
    };

    // Return the minimum element (or element-based computation).
    _.min = function(obj, iterator, context) {
        if (!iterator && _.isArray(obj) && obj[0] === +obj[0] && obj.length < 65535) {
            return Math.min.apply(Math, obj);
        }
        var result = Infinity, lastComputed = Infinity;
        each(obj, function(value, index, list) {
            var computed = iterator ? iterator.call(context, value, index, list) : value;
            if (computed < lastComputed) {
                result = value;
                lastComputed = computed;
            }
        });
        return result;
    };

    // Shuffle an array, using the modern version of the
    // [Fisher-Yates shuffle](http://en.wikipedia.org/wiki/Fisher–Yates_shuffle).
    _.shuffle = function(obj) {
        var rand;
        var index = 0;
        var shuffled = [];
        each(obj, function(value) {
            rand = _.random(index++);
            shuffled[index - 1] = shuffled[rand];
            shuffled[rand] = value;
        });
        return shuffled;
    };

    // Sample **n** random values from a collection.
    // If **n** is not specified, returns a single random element.
    // The internal `guard` argument allows it to work with `map`.
    _.sample = function(obj, n, guard) {
        if (n == null || guard) {
            if (obj.length !== +obj.length)
                obj = _.values(obj);
            return obj[_.random(obj.length - 1)];
        }
        return _.shuffle(obj).slice(0, Math.max(0, n));
    };

    // An internal function to generate lookup iterators.
    var lookupIterator = function(value) {
        if (value == null)
            return _.identity;
        if (_.isFunction(value))
            return value;
        return _.property(value);
    };

    // Sort the object's values by a criterion produced by an iterator.
    _.sortBy = function(obj, iterator, context) {
        iterator = lookupIterator(iterator);
        return _.pluck(_.map(obj, function(value, index, list) {
            return {
                value: value,
                index: index,
                criteria: iterator.call(context, value, index, list)
            };
        }).sort(function(left, right) {
            var a = left.criteria;
            var b = right.criteria;
            if (a !== b) {
                if (a > b || a === void 0)
                    return 1;
                if (a < b || b === void 0)
                    return -1;
            }
            return left.index - right.index;
        }), 'value');
    };

    // An internal function used for aggregate "group by" operations.
    var group = function(behavior) {
        return function(obj, iterator, context) {
            var result = {};
            iterator = lookupIterator(iterator);
            each(obj, function(value, index) {
                var key = iterator.call(context, value, index, obj);
                behavior(result, key, value);
            });
            return result;
        };
    };

    // Groups the object's values by a criterion. Pass either a string attribute
    // to group by, or a function that returns the criterion.
    _.groupBy = group(function(result, key, value) {
        _.has(result, key) ? result[key].push(value) : result[key] = [value];
    });

    // Indexes the object's values by a criterion, similar to `groupBy`, but for
    // when you know that your index values will be unique.
    _.indexBy = group(function(result, key, value) {
        result[key] = value;
    });

    // Counts instances of an object that group by a certain criterion. Pass
    // either a string attribute to count by, or a function that returns the
    // criterion.
    _.countBy = group(function(result, key) {
        _.has(result, key) ? result[key]++ : result[key] = 1;
    });

    // Use a comparator function to figure out the smallest index at which
    // an object should be inserted so as to maintain order. Uses binary search.
    _.sortedIndex = function(array, obj, iterator, context) {
        iterator = lookupIterator(iterator);
        var value = iterator.call(context, obj);
        var low = 0, high = array.length;
        while (low < high) {
            var mid = (low + high) >>> 1;
            iterator.call(context, array[mid]) < value ? low = mid + 1 : high = mid;
        }
        return low;
    };

    // Safely create a real, live array from anything iterable.
    _.toArray = function(obj) {
        if (!obj)
            return [];
        if (_.isArray(obj))
            return slice.call(obj);
        if (obj.length === +obj.length)
            return _.map(obj, _.identity);
        return _.values(obj);
    };

    // Return the number of elements in an object.
    _.size = function(obj) {
        if (obj == null)
            return 0;
        return (obj.length === +obj.length) ? obj.length : _.keys(obj).length;
    };

    // Array Functions
    // ---------------

    // Get the first element of an array. Passing **n** will return the first N
    // values in the array. Aliased as `head` and `take`. The **guard** check
    // allows it to work with `_.map`.
    _.first = _.head = _.take = function(array, n, guard) {
        if (array == null)
            return void 0;
        if ((n == null) || guard)
            return array[0];
        if (n < 0)
            return [];
        return slice.call(array, 0, n);
    };

    // Returns everything but the last entry of the array. Especially useful on
    // the arguments object. Passing **n** will return all the values in
    // the array, excluding the last N. The **guard** check allows it to work with
    // `_.map`.
    _.initial = function(array, n, guard) {
        return slice.call(array, 0, array.length - ((n == null) || guard ? 1 : n));
    };

    // Get the last element of an array. Passing **n** will return the last N
    // values in the array. The **guard** check allows it to work with `_.map`.
    _.last = function(array, n, guard) {
        if (array == null)
            return void 0;
        if ((n == null) || guard)
            return array[array.length - 1];
        return slice.call(array, Math.max(array.length - n, 0));
    };

    // Returns everything but the first entry of the array. Aliased as `tail` and `drop`.
    // Especially useful on the arguments object. Passing an **n** will return
    // the rest N values in the array. The **guard**
    // check allows it to work with `_.map`.
    _.rest = _.tail = _.drop = function(array, n, guard) {
        return slice.call(array, (n == null) || guard ? 1 : n);
    };

    // Trim out all falsy values from an array.
    _.compact = function(array) {
        return _.filter(array, _.identity);
    };

    // Internal implementation of a recursive `flatten` function.
    var flatten = function(input, shallow, output) {
        if (shallow && _.every(input, _.isArray)) {
            return concat.apply(output, input);
        }
        each(input, function(value) {
            if (_.isArray(value) || _.isArguments(value)) {
                shallow ? push.apply(output, value) : flatten(value, shallow, output);
            } else {
                output.push(value);
            }
        });
        return output;
    };

    // Flatten out an array, either recursively (by default), or just one level.
    _.flatten = function(array, shallow) {
        return flatten(array, shallow, []);
    };

    // Return a version of the array that does not contain the specified value(s).
    _.without = function(array) {
        return _.difference(array, slice.call(arguments, 1));
    };

    // Split an array into two arrays: one whose elements all satisfy the given
    // predicate, and one whose elements all do not satisfy the predicate.
    _.partition = function(array, predicate) {
        var pass = [], fail = [];
        each(array, function(elem) {
            (predicate(elem) ? pass : fail).push(elem);
        });
        return [pass, fail];
    };

    // Produce a duplicate-free version of the array. If the array has already
    // been sorted, you have the option of using a faster algorithm.
    // Aliased as `unique`.
    _.uniq = _.unique = function(array, isSorted, iterator, context) {
        if (_.isFunction(isSorted)) {
            context = iterator;
            iterator = isSorted;
            isSorted = false;
        }
        var initial = iterator ? _.map(array, iterator, context) : array;
        var results = [];
        var seen = [];
        each(initial, function(value, index) {
            if (isSorted ? (!index || seen[seen.length - 1] !== value) : !_.contains(seen, value)) {
                seen.push(value);
                results.push(array[index]);
            }
        });
        return results;
    };

    // Produce an array that contains the union: each distinct element from all of
    // the passed-in arrays.
    _.union = function() {
        return _.uniq(_.flatten(arguments, true));
    };

    // Produce an array that contains every item shared between all the
    // passed-in arrays.
    _.intersection = function(array) {
        var rest = slice.call(arguments, 1);
        return _.filter(_.uniq(array), function(item) {
            return _.every(rest, function(other) {
                return _.contains(other, item);
            });
        });
    };

    // Take the difference between one array and a number of other arrays.
    // Only the elements present in just the first array will remain.
    _.difference = function(array) {
        var rest = concat.apply(ArrayProto, slice.call(arguments, 1));
        return _.filter(array, function(value) {
            return !_.contains(rest, value);
        });
    };

    // Zip together multiple lists into a single array -- elements that share
    // an index go together.
    _.zip = function() {
        var length = _.max(_.pluck(arguments, 'length').concat(0));
        var results = new Array(length);
        for (var i = 0; i < length; i++) {
            results[i] = _.pluck(arguments, '' + i);
        }
        return results;
    };

    // Converts lists into objects. Pass either a single array of `[key, value]`
    // pairs, or two parallel arrays of the same length -- one of keys, and one of
    // the corresponding values.
    _.object = function(list, values) {
        if (list == null)
            return {};
        var result = {};
        for (var i = 0, length = list.length; i < length; i++) {
            if (values) {
                result[list[i]] = values[i];
            } else {
                result[list[i][0]] = list[i][1];
            }
        }
        return result;
    };

    // If the browser doesn't supply us with indexOf (I'm looking at you, **MSIE**),
    // we need this function. Return the position of the first occurrence of an
    // item in an array, or -1 if the item is not included in the array.
    // Delegates to **ECMAScript 5**'s native `indexOf` if available.
    // If the array is large and already in sort order, pass `true`
    // for **isSorted** to use binary search.
    _.indexOf = function(array, item, isSorted) {
        if (array == null)
            return -1;
        var i = 0, length = array.length;
        if (isSorted) {
            if (typeof isSorted == 'number') {
                i = (isSorted < 0 ? Math.max(0, length + isSorted) : isSorted);
            } else {
                i = _.sortedIndex(array, item);
                return array[i] === item ? i : -1;
            }
        }
        if (nativeIndexOf && array.indexOf === nativeIndexOf)
            return array.indexOf(item, isSorted);
        for (; i < length; i++)
            if (array[i] === item)
                return i;
        return -1;
    };

    // Delegates to **ECMAScript 5**'s native `lastIndexOf` if available.
    _.lastIndexOf = function(array, item, from) {
        if (array == null)
            return -1;
        var hasIndex = from != null;
        if (nativeLastIndexOf && array.lastIndexOf === nativeLastIndexOf) {
            return hasIndex ? array.lastIndexOf(item, from) : array.lastIndexOf(item);
        }
        var i = (hasIndex ? from : array.length);
        while (i--)
            if (array[i] === item)
                return i;
        return -1;
    };

    // Generate an integer Array containing an arithmetic progression. A port of
    // the native Python `range()` function. See
    // [the Python documentation](http://docs.python.org/library/functions.html#range).
    _.range = function(start, stop, step) {
        if (arguments.length <= 1) {
            stop = start || 0;
            start = 0;
        }
        step = arguments[2] || 1;

        var length = Math.max(Math.ceil((stop - start) / step), 0);
        var idx = 0;
        var range = new Array(length);

        while (idx < length) {
            range[idx++] = start;
            start += step;
        }

        return range;
    };

    // Function (ahem) Functions
    // ------------------

    // Reusable constructor function for prototype setting.
    var ctor = function() {
    };

    // Create a function bound to a given object (assigning `this`, and arguments,
    // optionally). Delegates to **ECMAScript 5**'s native `Function.bind` if
    // available.
    _.bind = function(func, context) {
        var args, bound;
        if (nativeBind && func.bind === nativeBind)
            return nativeBind.apply(func, slice.call(arguments, 1));
        if (!_.isFunction(func))
            throw new TypeError;
        args = slice.call(arguments, 2);
        return bound = function() {
            if (!(this instanceof bound))
                return func.apply(context, args.concat(slice.call(arguments)));
            ctor.prototype = func.prototype;
            var self = new ctor;
            ctor.prototype = null;
            var result = func.apply(self, args.concat(slice.call(arguments)));
            if (Object(result) === result)
                return result;
            return self;
        };
    };

    // Partially apply a function by creating a version that has had some of its
    // arguments pre-filled, without changing its dynamic `this` context. _ acts
    // as a placeholder, allowing any combination of arguments to be pre-filled.
    _.partial = function(func) {
        var boundArgs = slice.call(arguments, 1);
        return function() {
            var position = 0;
            var args = boundArgs.slice();
            for (var i = 0, length = args.length; i < length; i++) {
                if (args[i] === _)
                    args[i] = arguments[position++];
            }
            while (position < arguments.length)
                args.push(arguments[position++]);
            return func.apply(this, args);
        };
    };

    // Bind a number of an object's methods to that object. Remaining arguments
    // are the method names to be bound. Useful for ensuring that all callbacks
    // defined on an object belong to it.
    _.bindAll = function(obj) {
        var funcs = slice.call(arguments, 1);
        if (funcs.length === 0)
            throw new Error('bindAll must be passed function names');
        each(funcs, function(f) {
            obj[f] = _.bind(obj[f], obj);
        });
        return obj;
    };

    // Memoize an expensive function by storing its results.
    _.memoize = function(func, hasher) {
        var memo = {};
        hasher || (hasher = _.identity);
        return function() {
            var key = hasher.apply(this, arguments);
            return _.has(memo, key) ? memo[key] : (memo[key] = func.apply(this, arguments));
        };
    };

    // Delays a function for the given number of milliseconds, and then calls
    // it with the arguments supplied.
    _.delay = function(func, wait) {
        var args = slice.call(arguments, 2);
        return setTimeout(function() {
            return func.apply(null, args);
        }, wait);
    };

    // Defers a function, scheduling it to run after the current call stack has
    // cleared.
    _.defer = function(func) {
        return _.delay.apply(_, [func, 1].concat(slice.call(arguments, 1)));
    };

    // Returns a function, that, when invoked, will only be triggered at most once
    // during a given window of time. Normally, the throttled function will run
    // as much as it can, without ever going more than once per `wait` duration;
    // but if you'd like to disable the execution on the leading edge, pass
    // `{leading: false}`. To disable execution on the trailing edge, ditto.
    _.throttle = function(func, wait, options) {
        var context, args, result;
        var timeout = null;
        var previous = 0;
        options || (options = {});
        var later = function() {
            previous = options.leading === false ? 0 : _.now();
            timeout = null;
            result = func.apply(context, args);
            context = args = null;
        };
        return function() {
            var now = _.now();
            if (!previous && options.leading === false)
                previous = now;
            var remaining = wait - (now - previous);
            context = this;
            args = arguments;
            if (remaining <= 0) {
                clearTimeout(timeout);
                timeout = null;
                previous = now;
                result = func.apply(context, args);
                context = args = null;
            } else if (!timeout && options.trailing !== false) {
                timeout = setTimeout(later, remaining);
            }
            return result;
        };
    };

    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
    _.debounce = function(func, wait, immediate) {
        var timeout, args, context, timestamp, result;

        var later = function() {
            var last = _.now() - timestamp;
            if (last < wait) {
                timeout = setTimeout(later, wait - last);
            } else {
                timeout = null;
                if (!immediate) {
                    result = func.apply(context, args);
                    context = args = null;
                }
            }
        };

        return function() {
            context = this;
            args = arguments;
            timestamp = _.now();
            var callNow = immediate && !timeout;
            if (!timeout) {
                timeout = setTimeout(later, wait);
            }
            if (callNow) {
                result = func.apply(context, args);
                context = args = null;
            }

            return result;
        };
    };

    // Returns a function that will be executed at most one time, no matter how
    // often you call it. Useful for lazy initialization.
    _.once = function(func) {
        var ran = false, memo;
        return function() {
            if (ran)
                return memo;
            ran = true;
            memo = func.apply(this, arguments);
            func = null;
            return memo;
        };
    };

    // Returns the first function passed as an argument to the second,
    // allowing you to adjust arguments, run code before and after, and
    // conditionally execute the original function.
    _.wrap = function(func, wrapper) {
        return _.partial(wrapper, func);
    };

    // Returns a function that is the composition of a list of functions, each
    // consuming the return value of the function that follows.
    _.compose = function() {
        var funcs = arguments;
        return function() {
            var args = arguments;
            for (var i = funcs.length - 1; i >= 0; i--) {
                args = [funcs[i].apply(this, args)];
            }
            return args[0];
        };
    };

    // Returns a function that will only be executed after being called N times.
    _.after = function(times, func) {
        return function() {
            if (--times < 1) {
                return func.apply(this, arguments);
            }
        };
    };

    // Object Functions
    // ----------------

    // Retrieve the names of an object's properties.
    // Delegates to **ECMAScript 5**'s native `Object.keys`
    _.keys = function(obj) {
        if (!_.isObject(obj))
            return [];
        if (nativeKeys)
            return nativeKeys(obj);
        var keys = [];
        for (var key in obj)
            if (_.has(obj, key))
                keys.push(key);
        return keys;
    };

    // Retrieve the values of an object's properties.
    _.values = function(obj) {
        var keys = _.keys(obj);
        var length = keys.length;
        var values = new Array(length);
        for (var i = 0; i < length; i++) {
            values[i] = obj[keys[i]];
        }
        return values;
    };

    // Convert an object into a list of `[key, value]` pairs.
    _.pairs = function(obj) {
        var keys = _.keys(obj);
        var length = keys.length;
        var pairs = new Array(length);
        for (var i = 0; i < length; i++) {
            pairs[i] = [keys[i], obj[keys[i]]];
        }
        return pairs;
    };

    // Invert the keys and values of an object. The values must be serializable.
    _.invert = function(obj) {
        var result = {};
        var keys = _.keys(obj);
        for (var i = 0, length = keys.length; i < length; i++) {
            result[obj[keys[i]]] = keys[i];
        }
        return result;
    };

    // Return a sorted list of the function names available on the object.
    // Aliased as `methods`
    _.functions = _.methods = function(obj) {
        var names = [];
        for (var key in obj) {
            if (_.isFunction(obj[key]))
                names.push(key);
        }
        return names.sort();
    };

    // Extend a given object with all the properties in passed-in object(s).
    _.extend = function(obj) {
        each(slice.call(arguments, 1), function(source) {
            if (source) {
                for (var prop in source) {
                    obj[prop] = source[prop];
                }
            }
        });
        return obj;
    };

    // Return a copy of the object only containing the whitelisted properties.
    _.pick = function(obj) {
        var copy = {};
        var keys = concat.apply(ArrayProto, slice.call(arguments, 1));
        each(keys, function(key) {
            if (key in obj)
                copy[key] = obj[key];
        });
        return copy;
    };

    // Return a copy of the object without the blacklisted properties.
    _.omit = function(obj) {
        var copy = {};
        var keys = concat.apply(ArrayProto, slice.call(arguments, 1));
        for (var key in obj) {
            if (!_.contains(keys, key))
                copy[key] = obj[key];
        }
        return copy;
    };

    // Fill in a given object with default properties.
    _.defaults = function(obj) {
        each(slice.call(arguments, 1), function(source) {
            if (source) {
                for (var prop in source) {
                    if (obj[prop] === void 0)
                        obj[prop] = source[prop];
                }
            }
        });
        return obj;
    };

    // Create a (shallow-cloned) duplicate of an object.
    _.clone = function(obj) {
        if (!_.isObject(obj))
            return obj;
        return _.isArray(obj) ? obj.slice() : _.extend({}, obj);
    };

    // Invokes interceptor with the obj, and then returns obj.
    // The primary purpose of this method is to "tap into" a method chain, in
    // order to perform operations on intermediate results within the chain.
    _.tap = function(obj, interceptor) {
        interceptor(obj);
        return obj;
    };

    // Internal recursive comparison function for `isEqual`.
    var eq = function(a, b, aStack, bStack) {
        // Identical objects are equal. `0 === -0`, but they aren't identical.
        // See the [Harmony `egal` proposal](http://wiki.ecmascript.org/doku.php?id=harmony:egal).
        if (a === b)
            return a !== 0 || 1 / a == 1 / b;
        // A strict comparison is necessary because `null == undefined`.
        if (a == null || b == null)
            return a === b;
        // Unwrap any wrapped objects.
        if (a instanceof _)
            a = a._wrapped;
        if (b instanceof _)
            b = b._wrapped;
        // Compare `[[Class]]` names.
        var className = toString.call(a);
        if (className != toString.call(b))
            return false;
        switch (className) {
            // Strings, numbers, dates, and booleans are compared by value.
            case '[object String]':
                // Primitives and their corresponding object wrappers are equivalent; thus, `"5"` is
                // equivalent to `new String("5")`.
                return a == String(b);
            case '[object Number]':
                // `NaN`s are equivalent, but non-reflexive. An `egal` comparison is performed for
                // other numeric values.
                return a != +a ? b != +b : (a == 0 ? 1 / a == 1 / b : a == +b);
            case '[object Date]':
            case '[object Boolean]':
                // Coerce dates and booleans to numeric primitive values. Dates are compared by their
                // millisecond representations. Note that invalid dates with millisecond representations
                // of `NaN` are not equivalent.
                return +a == +b;
                // RegExps are compared by their source patterns and flags.
            case '[object RegExp]':
                return a.source == b.source &&
                        a.global == b.global &&
                        a.multiline == b.multiline &&
                        a.ignoreCase == b.ignoreCase;
        }
        if (typeof a != 'object' || typeof b != 'object')
            return false;
        // Assume equality for cyclic structures. The algorithm for detecting cyclic
        // structures is adapted from ES 5.1 section 15.12.3, abstract operation `JO`.
        var length = aStack.length;
        while (length--) {
            // Linear search. Performance is inversely proportional to the number of
            // unique nested structures.
            if (aStack[length] == a)
                return bStack[length] == b;
        }
        // Objects with different constructors are not equivalent, but `Object`s
        // from different frames are.
        var aCtor = a.constructor, bCtor = b.constructor;
        if (aCtor !== bCtor && !(_.isFunction(aCtor) && (aCtor instanceof aCtor) &&
                _.isFunction(bCtor) && (bCtor instanceof bCtor))
                && ('constructor' in a && 'constructor' in b)) {
            return false;
        }
        // Add the first object to the stack of traversed objects.
        aStack.push(a);
        bStack.push(b);
        var size = 0, result = true;
        // Recursively compare objects and arrays.
        if (className == '[object Array]') {
            // Compare array lengths to determine if a deep comparison is necessary.
            size = a.length;
            result = size == b.length;
            if (result) {
                // Deep compare the contents, ignoring non-numeric properties.
                while (size--) {
                    if (!(result = eq(a[size], b[size], aStack, bStack)))
                        break;
                }
            }
        } else {
            // Deep compare objects.
            for (var key in a) {
                if (_.has(a, key)) {
                    // Count the expected number of properties.
                    size++;
                    // Deep compare each member.
                    if (!(result = _.has(b, key) && eq(a[key], b[key], aStack, bStack)))
                        break;
                }
            }
            // Ensure that both objects contain the same number of properties.
            if (result) {
                for (key in b) {
                    if (_.has(b, key) && !(size--))
                        break;
                }
                result = !size;
            }
        }
        // Remove the first object from the stack of traversed objects.
        aStack.pop();
        bStack.pop();
        return result;
    };

    // Perform a deep comparison to check if two objects are equal.
    _.isEqual = function(a, b) {
        return eq(a, b, [], []);
    };

    // Is a given array, string, or object empty?
    // An "empty" object has no enumerable own-properties.
    _.isEmpty = function(obj) {
        if (obj == null)
            return true;
        if (_.isArray(obj) || _.isString(obj))
            return obj.length === 0;
        for (var key in obj)
            if (_.has(obj, key))
                return false;
        return true;
    };

    // Is a given value a DOM element?
    _.isElement = function(obj) {
        return !!(obj && obj.nodeType === 1);
    };

    // Is a given value an array?
    // Delegates to ECMA5's native Array.isArray
    _.isArray = nativeIsArray || function(obj) {
        return toString.call(obj) == '[object Array]';
    };

    // Is a given variable an object?
    _.isObject = function(obj) {
        return obj === Object(obj);
    };

    // Add some isType methods: isArguments, isFunction, isString, isNumber, isDate, isRegExp.
    each(['Arguments', 'Function', 'String', 'Number', 'Date', 'RegExp'], function(name) {
        _['is' + name] = function(obj) {
            return toString.call(obj) == '[object ' + name + ']';
        };
    });

    // Define a fallback version of the method in browsers (ahem, IE), where
    // there isn't any inspectable "Arguments" type.
    if (!_.isArguments(arguments)) {
        _.isArguments = function(obj) {
            return !!(obj && _.has(obj, 'callee'));
        };
    }

    // Optimize `isFunction` if appropriate.
    if (typeof (/./) !== 'function') {
        _.isFunction = function(obj) {
            return typeof obj === 'function';
        };
    }

    // Is a given object a finite number?
    _.isFinite = function(obj) {
        return isFinite(obj) && !isNaN(parseFloat(obj));
    };

    // Is the given value `NaN`? (NaN is the only number which does not equal itself).
    _.isNaN = function(obj) {
        return _.isNumber(obj) && obj != +obj;
    };

    // Is a given value a boolean?
    _.isBoolean = function(obj) {
        return obj === true || obj === false || toString.call(obj) == '[object Boolean]';
    };

    // Is a given value equal to null?
    _.isNull = function(obj) {
        return obj === null;
    };

    // Is a given variable undefined?
    _.isUndefined = function(obj) {
        return obj === void 0;
    };

    // Shortcut function for checking if an object has a given property directly
    // on itself (in other words, not on a prototype).
    _.has = function(obj, key) {
        return hasOwnProperty.call(obj, key);
    };

    // Utility Functions
    // -----------------

    // Run Underscore.js in *noConflict* mode, returning the `_` variable to its
    // previous owner. Returns a reference to the Underscore object.
    _.noConflict = function() {
        root._ = previousUnderscore;
        return this;
    };

    // Keep the identity function around for default iterators.
    _.identity = function(value) {
        return value;
    };

    _.constant = function(value) {
        return function() {
            return value;
        };
    };

    _.property = function(key) {
        return function(obj) {
            return obj[key];
        };
    };

    // Returns a predicate for checking whether an object has a given set of `key:value` pairs.
    _.matches = function(attrs) {
        return function(obj) {
            if (obj === attrs)
                return true; //avoid comparing an object to itself.
            for (var key in attrs) {
                if (attrs[key] !== obj[key])
                    return false;
            }
            return true;
        }
    };

    // Run a function **n** times.
    _.times = function(n, iterator, context) {
        var accum = Array(Math.max(0, n));
        for (var i = 0; i < n; i++)
            accum[i] = iterator.call(context, i);
        return accum;
    };

    // Return a random integer between min and max (inclusive).
    _.random = function(min, max) {
        if (max == null) {
            max = min;
            min = 0;
        }
        return min + Math.floor(Math.random() * (max - min + 1));
    };

    // A (possibly faster) way to get the current timestamp as an integer.
    _.now = Date.now || function() {
        return new Date().getTime();
    };

    // List of HTML entities for escaping.
    var entityMap = {
        escape: {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#x27;'
        }
    };
    entityMap.unescape = _.invert(entityMap.escape);

    // Regexes containing the keys and values listed immediately above.
    var entityRegexes = {
        escape: new RegExp('[' + _.keys(entityMap.escape).join('') + ']', 'g'),
        unescape: new RegExp('(' + _.keys(entityMap.unescape).join('|') + ')', 'g')
    };

    // Functions for escaping and unescaping strings to/from HTML interpolation.
    _.each(['escape', 'unescape'], function(method) {
        _[method] = function(string) {
            if (string == null)
                return '';
            return ('' + string).replace(entityRegexes[method], function(match) {
                return entityMap[method][match];
            });
        };
    });

    // If the value of the named `property` is a function then invoke it with the
    // `object` as context; otherwise, return it.
    _.result = function(object, property) {
        if (object == null)
            return void 0;
        var value = object[property];
        return _.isFunction(value) ? value.call(object) : value;
    };

    // Add your own custom functions to the Underscore object.
    _.mixin = function(obj) {
        each(_.functions(obj), function(name) {
            var func = _[name] = obj[name];
            _.prototype[name] = function() {
                var args = [this._wrapped];
                push.apply(args, arguments);
                return result.call(this, func.apply(_, args));
            };
        });
    };

    // Generate a unique integer id (unique within the entire client session).
    // Useful for temporary DOM ids.
    var idCounter = 0;
    _.uniqueId = function(prefix) {
        var id = ++idCounter + '';
        return prefix ? prefix + id : id;
    };

    // By default, Underscore uses ERB-style template delimiters, change the
    // following template settings to use alternative delimiters.
    _.templateSettings = {
        evaluate: /<%([\s\S]+?)%>/g,
        interpolate: /<%=([\s\S]+?)%>/g,
        escape: /<%-([\s\S]+?)%>/g
    };

    // When customizing `templateSettings`, if you don't want to define an
    // interpolation, evaluation or escaping regex, we need one that is
    // guaranteed not to match.
    var noMatch = /(.)^/;

    // Certain characters need to be escaped so that they can be put into a
    // string literal.
    var escapes = {
        "'": "'",
        '\\': '\\',
        '\r': 'r',
        '\n': 'n',
        '\t': 't',
        '\u2028': 'u2028',
        '\u2029': 'u2029'
    };

    var escaper = /\\|'|\r|\n|\t|\u2028|\u2029/g;

    // JavaScript micro-templating, similar to John Resig's implementation.
    // Underscore templating handles arbitrary delimiters, preserves whitespace,
    // and correctly escapes quotes within interpolated code.
    _.template = function(text, data, settings) {
        var render;
        settings = _.defaults({}, settings, _.templateSettings);

        // Combine delimiters into one regular expression via alternation.
        var matcher = new RegExp([
            (settings.escape || noMatch).source,
            (settings.interpolate || noMatch).source,
            (settings.evaluate || noMatch).source
        ].join('|') + '|$', 'g');

        // Compile the template source, escaping string literals appropriately.
        var index = 0;
        var source = "__p+='";
        text.replace(matcher, function(match, escape, interpolate, evaluate, offset) {
            source += text.slice(index, offset)
                    .replace(escaper, function(match) {
                        return '\\' + escapes[match];
                    });

            if (escape) {
                source += "'+\n((__t=(" + escape + "))==null?'':_.escape(__t))+\n'";
            }
            if (interpolate) {
                source += "'+\n((__t=(" + interpolate + "))==null?'':__t)+\n'";
            }
            if (evaluate) {
                source += "';\n" + evaluate + "\n__p+='";
            }
            index = offset + match.length;
            return match;
        });
        source += "';\n";

        // If a variable is not specified, place data values in local scope.
        if (!settings.variable)
            source = 'with(obj||{}){\n' + source + '}\n';

        source = "var __t,__p='',__j=Array.prototype.join," +
                "print=function(){__p+=__j.call(arguments,'');};\n" +
                source + "return __p;\n";

        try {
            render = new Function(settings.variable || 'obj', '_', source);
        } catch (e) {
            e.source = source;
            throw e;
        }

        if (data)
            return render(data, _);
        var template = function(data) {
            return render.call(this, data, _);
        };

        // Provide the compiled function source as a convenience for precompilation.
        template.source = 'function(' + (settings.variable || 'obj') + '){\n' + source + '}';

        return template;
    };

    // Add a "chain" function, which will delegate to the wrapper.
    _.chain = function(obj) {
        return _(obj).chain();
    };

    // OOP
    // ---------------
    // If Underscore is called as a function, it returns a wrapped object that
    // can be used OO-style. This wrapper holds altered versions of all the
    // underscore functions. Wrapped objects may be chained.

    // Helper function to continue chaining intermediate results.
    var result = function(obj) {
        return this._chain ? _(obj).chain() : obj;
    };

    // Add all of the Underscore functions to the wrapper object.
    _.mixin(_);

    // Add all mutator Array functions to the wrapper.
    each(['pop', 'push', 'reverse', 'shift', 'sort', 'splice', 'unshift'], function(name) {
        var method = ArrayProto[name];
        _.prototype[name] = function() {
            var obj = this._wrapped;
            method.apply(obj, arguments);
            if ((name == 'shift' || name == 'splice') && obj.length === 0)
                delete obj[0];
            return result.call(this, obj);
        };
    });

    // Add all accessor Array functions to the wrapper.
    each(['concat', 'join', 'slice'], function(name) {
        var method = ArrayProto[name];
        _.prototype[name] = function() {
            return result.call(this, method.apply(this._wrapped, arguments));
        };
    });

    _.extend(_.prototype, {
        // Start chaining a wrapped Underscore object.
        chain: function() {
            this._chain = true;
            return this;
        },
        // Extracts the result from a wrapped and chained object.
        value: function() {
            return this._wrapped;
        }

    });



    ggmvc.events = {}

    ggmvc.controller = {}



//pagebeforechange
//Triggered twice during the page change cyle: First prior to any page loading or transition and
// next after page loading completes successfully, but before the browser history has been modified by the navigation process.

    $(window).on("pagebeforechange", function(event, data) {

    });

//pagebeforecreate
//Triggered on the page being initialized, before most plugin auto-initialization occurs.
    $(window).on("pagebeforecreate", function(event, data) {

    });

//pagebeforehide
//Triggered on the “fromPage” we are transitioning away from, before the actual transition animation is kicked off.
    $(window).on("pagebeforehide", function(event, data) {

    });

//pagebeforeload
//Triggered before any load request is made.
    $(window).on("pagebeforeload", function(event, data) {

    });

//pagebeforeshow
//Triggered on the “toPage” we are transitioning to, before the actual transition animation is kicked off.
    $(window).on("pagebeforeshow", function(event, data) {

    });
//pagechange
//This event is triggered after the changePage() request has finished loading the page into the DOM and all page transition animations have completed.
    $(window).on("pagechange", function(event, data) {

    });
//pagechangefailed
//This event is triggered when the changePage() request fails to load the page. Callbacks for this particular event will be passed a data object as the 2nd arg.
    $(window).on("pagechangefailed", function(event, data) {

    });
//pagecreate
//Triggered when the page has been created in the DOM (via ajax or other) but before all widgets have had an opportunity to enhance the contained markup.
    $(window).on("pagecreate", function(event, data) {

    });
//pagehide
//Triggered on the “fromPage” after the transition animation has completed.
    $(window).on("pagehide", function(event, data) {

    });
//pageinit
//Triggered on the page being initialized, after initialization occurs.
    $(window).on("pageinit", function(event, data) {

    });

//pageload
//Triggered after the page is successfully loaded and inserted into the DOM.
    $(window).on("pageload", function(event, data) {

    });
//pageloadfailed
//Triggered if the page load request failed.
    $(window).on("pageloadfailed", function(event, data) {

    });
//pageremove
//Triggered just before the framework attempts to remove an external page from the DOM.
    $(window).on("pageremove", function(event, data) {

    });
//pageshow
//Triggered on the “toPage” after the transition animation has completed.
    $(window).on("pageshow", function(event, data) {

    });



    var extend = function() {
        _.extend(this, arguments);
    };


    ggmvc.controller.extend = extend;

    return ggmvc;

});

﻿/*---------------------------------------------------------------------------login--------------------------------------------------------------------------------------------------------*/
//page before show event
        $("#login").on('pagebeforeshow', function() {
    //reset form
    $(".hl-login > input").val("");
});

//page show event
$("#login").on('pageshow', function() {
    //initialiaze
    login.init();
});

var login = {
    nextPage: "",
    //init
    init: function() {
        $("#loginConfirm").off("click").click(function() {
            login.login();
        });
        $("#loginCancel").off("click").click(function() {
            //move to welcome page
            $.mobile.changePage($("#cp"), {
                changeHash: true
            });
        });
    },
    //login
    login: function() {
        //show load
        $.mobile.loading('show');
        server.login({id: $("#txtLogin").val(), password: $("#txtPassword").val()}, function(data) {
            //hide load
            $.mobile.loading('hide');
            app.login(data);
        });
    }
}

﻿/*---------------------------------------------------------------------------cp--------------------------------------------------------------------------------------------------------*/
//page show event
        $("#cp").on('pageshow', function() {
    //initialiaze
    cp.init();
});

//refresh event
$(document).on('refresh', function(event, data) {
    if (data == "cp") {
        cp.updateDrawNumber(true);
    }
});

var cp = {
    //init
    init: function() {
        //reset user game related cache
        cache.resetGame();
        var data = cache.getData();
        if (data == null) {
            //show load
            $.mobile.loading('show');
            server.getConfig(function(data) {
                //hide load
                $.mobile.loading('hide');
                if (data != null) {
                    //cache config
                    cache.setData(data);
                    //render
                    cp.render(data);
                }
            });
        }
        else {
            cp.render(data);
        }
    },
    //render
    render: function(data) {
        var games = data.games, g = [], gameLabel = "";
        if (games.length > 0) {
            $.each(games, function(index) {
                gameLabel = utils.getGameLabel(this.id);
                g.push('<li><a href="#orderSelect?lottery=');
                g.push(this.id);
                g.push('" id="game');
                g.push(this.id);
                g.push('" title="');
                g.push(gameLabel);
                g.push('"><img src="css/images/thumb-');
                g.push(this.id);
                g.push('.png" class="hl-thumbnail" /><h3>');
                g.push(gameLabel);
                g.push('</h3><p>&nbsp;</p></a></li>');
            });
        }
        else {
            g.push('<li>');
            g.push(label.noRecord);
            g.push('</li>');
        }

        $("#gameList").html(g.join("")).listview('refresh', true);
        //update draw number
        cp.updateDrawNumber(false);
    },
    //update draw number
    updateDrawNumber: function(showProgress) {
        var data = cache.getData();
        if (data != null) {
            if (showProgress) {
                $(".dn-refresh").hide();
                $(".dn-progress").show();
            }
            var games = data.games;
            $.each(games, function() {
                if (!isEmpty(this.desc)) {
                    $("#game" + this.id + " > p").text(this.desc);
                }
            });
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
        } else {
            //avoid infinite loop by only re-init when show progress is true
            if (showProgress) {
                cp.init();
            }
        }
    }
}

﻿/*---------------------------------------------------------------------------draw--------------------------------------------------------------------------------------------------------*/
//page before show event
        $("#draw").on('pagebeforeshow', function() {
    //clear
    $("#drawList").empty();
});

//page show event
$("#draw").on('pageshow', function() {
    //initialiaze
    draw.init();
});

//page init event
$('#draw').on('pageinit', function(event) {
    $("#drawGameList").change(function(event, ui) {
        draw.search(false);
    });
});

//refresh event
$(document).on('refresh', function(event, data) {
    if (data == "draw") {
        draw.search(true);
    }
});

var draw = {
    //init
    init: function() {
        //clear content
        $("#drawList").empty();
        var data = cache.getData();
        if (data == null) {
            //show load
            $.mobile.loading('show');
            server.getConfig(function(data) {
                //hide load
                $.mobile.loading('hide');
                if (data != null) {
                    //cache config
                    cache.setData(data);
                    //render
                    draw.render();
                }
            });
        }
        else {
            draw.render();
        }
    },
    //render
    render: function() {
        var data = cache.getData(), gameId = "", drawGameList = $("#drawGameList");
        if (data != null) {
            if (drawGameList.html().length > 0) {
                draw.search(false);
            }
            else {
                var g = [],
                        gameLabel = "";
                $.each(data.games, function() {
                    gameLabel = utils.getGameLabel(this.id);
                    //set game code
                    if (gameId.length == 0) {
                        gameId = this.id;
                    }
                    g.push('<option value="');
                    g.push(this.id);
                    g.push('">');
                    g.push(gameLabel);
                    g.push('</option>');
                });
                drawGameList.empty().html(g.join(""));
                //reset dropdown
                drawGameList[0].selectedIndex = 0;
                drawGameList.selectmenu("refresh", true);
                if (gameId.length > 0) {
                    draw.search(false);
                }
            }
        }
    },
    //search
    search: function(showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('show');
        }
        var gameId = $("#drawGameList").val();
        server.getDrawResult(gameId, function(data) {
            if (data != null) {
                var r = [];
                gameLabel = "";
                if (data.length > 0) {
                    $.each(data, function(index) {
                        r.push('<li>');
                        r.push(label.drawNumber.replace("{0}", this.id));
//                        r.push('<span class="hl-spacer"></span>');
//                        r.push(this.date);
                        r.push('<br/><span class="hl-draw">');
                        r.push(this.val);
                        r.push('</span></li>');
                    });
                }
                else {
                    r.push('<li>');
                    r.push(label.noRecord);
                    r.push('</li>');
                }
                $("#drawList").html(r.join("")).listview('refresh');
            }
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    }
}

﻿/*---------------------------------------------------------------------------search--------------------------------------------------------------------------------------------------------*/
//page before change event
        $(document).on('pagebeforechange', function(e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
                re = /^#search/;

        if (u.hash.search(re) !== -1) {
            var profile = cache.getProfile();

            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#search";

                e.preventDefault();

                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

//page before show event
$("#search").on('pagebeforeshow', function() {
    var profile = cache.getProfile();
    if (profile != null && profile.id.length > 0) {
        //reset page number
        search.pageNumber = 1;
        $(".hl-search-title-container, #searchMoreContainer").hide();
        //clear
        $("#searchList").empty();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#search").on('pageshow', function() {
    //initialiaze
    search.init();
});

//page init event
$('#search').on('pageinit', function(event) {
    $("#searchGameList").change(function(event, ui) {
        //reset page number
        search.pageNumber = 1;
        $(".hl-search-title-container, #searchMoreContainer").hide();
        //clear
        $("#searchList").empty();
        search.search(false);
    });

    $("#searchRangeList").change(function(event, ui) {
        //reset page number
        search.pageNumber = 1;
        $(".hl-search-title-container, #searchMoreContainer").hide();
        //clear
        $("#searchList").empty();
        search.search(false);
    });

    $("#searchMoreLink").unbind("click").click(function() {
        //increase page number
        search.pageNumber++;
        search.search(false);
    });
});

//refresh event
$(document).on('refresh', function(event, data) {
    if (data == "search") {
        //reset page number
        search.pageNumber = 1;
        search.search(true);
    }
});

var search = {
    pageNumber: 1,
    //init
    init: function() {
        //clear
        $("#searchList").empty();
        var data = cache.getData();
        if (data == null) {
            //show load
            $.mobile.loading('show');
            server.getConfig(function(data) {
                //hide load
                $.mobile.loading('hide');
                if (data != null) {
                    //cache config
                    cache.setData(data);
                    //render
                    search.render();
                }
            });
        }
        else {
            search.render();
        }
    },
    //render
    render: function() {
        var data = cache.getData(),
                gameId = "",
                searchGameList = $("#searchGameList"),
                searchRangeList = $("#searchRangeList");
        if (data != null) {
            if (searchGameList.html().length > 0) {
                search.search(false);
            }
            else {
                var g = [],
                        d = [],
                        gameLabel = "";
                $.each(data.games, function() {
                    gameLabel = utils.getGameLabel(this.id);
                    //set game code
                    if (gameId.length == 0) {
                        gameId = this.id;
                    }
                    g.push('<option value="');
                    g.push(this.id);
                    g.push('">');
                    g.push(gameLabel);
                    g.push('</option>');
                });
                searchGameList.empty().html(g.join(""));
                //reset dropdown
                searchGameList[0].selectedIndex = 0;
                searchGameList.selectmenu("refresh", true);
                for (var i = 1; i < 8; i++) {
                    d.push('<option value="');
                    d.push(i.toString());
                    d.push('">');
                    d.push(i.toString());
                    d.push("天</option>");
                }
                searchRangeList.empty().html(d.join(""));
                //reset dropdown
                searchRangeList[0].selectedIndex = 0;
                searchRangeList.selectmenu("refresh", true);
                if (gameId.length > 0) {
                    search.search(false);
                }
            }
        }
    },
    //search
    search: function(showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('show');
        }
        var item = {};
        item.gameId = $("#searchGameList").val();
        item.day = $("#searchRangeList").val();
        item.pageNumber = search.pageNumber;
        item.pageSize = setting.search.pageSize;
        server.getOrders(item, function(data) {
            if (data != null) {
                var s = [];
                if (data.r.length > 0) {
                    $.each(data.r, function(index) {
                        s.push('<li><a href="#detail?id=' + this.wrap_id + '&trace_id=' + this.trace_id);
                        s.push('"><div class="hl-search-search"><div class="hl-search-bet">');
                        s.push(this.create_time);
                        s.push('</div><div class="hl-search-order">');
                        s.push((this.prize_mode));
                        s.push('</div><div class="hl-search-amount">');
                        s.push(utils.digits(this.amount, 2));
                        s.push('</div><div class="hl-search-status">');
                        s.push((this.status));
                        s.push('</div></div></a></li>');
                    });
                }
                else {
                    s.push('<li>');
                    s.push(label.noRecord);
                    s.push('</div></li>');
                }
                if (showProgress) {
                    $("#searchList").html(s.join("")).listview('refresh');
                }
                else {
                    $("#searchList").append(s.join("")).listview('refresh');
                }
                //show title
                $(".hl-search-title-container").show();
                //show or hide more button
                if (data.r.length > 0 && data.c > search.pageNumber) {
                    $("#searchMoreContainer").show();
                }
                else {
                    $("#searchMoreContainer").hide();
                }
                if (showProgress) {
                    $(".dn-progress").hide();
                    $(".dn-refresh").show();
                }
                else {
                    //hide load
                    $.mobile.loading('hide');
                }
            }
        });
    }
}

﻿/*---------------------------------------------------------------------------detail--------------------------------------------------------------------------------------------------------*/
//page before change event
        $(document).on("pagebeforechange", function(e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
                re = /^#detail/;
        if (u.hash.search(re) !== -1) {
            detail.id = getUrlParam('id', u.hash);
            detail.trace_id = getUrlParam('trace_id', u.hash);
            var profile = cache.getProfile();
            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#search";
                e.preventDefault();
                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

//page before show event
$("#detail").on('pagebeforeshow', function() {
    //hide content
    $("#detailNumber").text("");
    $(".hl-detail-main, #withdraw").hide();

    var profile = cache.getProfile();

    if (profile != null && profile.id.length > 0) {
        //clear
        $("#detailList").empty();
    }
    else {
        $.mobile.changePage($("#search"), {
            changeHash: false
        });
    }
});

//page show event
$("#detail").on('pageshow', function() {
    //initialiaze
    detail.init();
});

var detail = {
    id: "",
    //init
    init: function() {
        if (detail.id.length > 0) {
            //show load
            $.mobile.loading('show');
            server.getDetail({'id': detail.id, 'trace_id': detail.trace_id}, function(data) {
                //hide load
                $.mobile.loading('hide');

                if (data != null) {
                    //render
                    detail.render(data);
                }
                else {
                    $("#detailNumber").text(label.noRecord);
                }
            });
        }
        else {
            $("#detailNumber").text(label.noRecord);
        }
    },
    //render
    render: function(data) {
        var o = [];
        //number list
        $.each(data.projects, function() {
            o.push('<li>');
            o.push('<span class="hl-detail-game">');
            o.push(this.cname);
            o.push('</span><span class="hl-detail-number">');
            o.push(this.code);
            o.push('</span><span class="hl-detail-bet">');
            o.push(this.single_num);
            o.push('注</span></li>');
        });
        $("#detailList").html(o.join("")).listview('refresh');
        //detail

        if (data.trace) {
            $(".hl-detail-normal").hide();
            $(".hl-detail-cno").show();
            $("#detailNumber").text(data.trace.wrap_id);
            $("#detail2_lottery").text(data.lottery.cname);
            $("#detail2_modes").text(data.modes);
            $("#detail2_single_num").text(data.trace.single_num);
            $("#detail2_total_multiple").text(data.trace.total_multiple);
            $("#detail2_trace_times").text(data.trace.trace_times);
            $("#detail2_total_amount").text(data.trace.total_amount);
            $("#detail2_prizeMode").text(data.prizeMode);
            $("#detail2_stop_on_win").text(data.trace.stop_on_win);
            $("#detail2_status").text(data.trace.status);
            $("#detail2_create_time").text(data.trace.create_time);
            var pkids = [];
            var oPackages = [];
            var cancel_status = false;
            $.each(data.packages, function() {
                if (this.cancel_status == '0')
                    cancel_status = true;
                pkids.push(this.package_id);
                oPackages.push('<li>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">追号期号:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.issue + '</label></div>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">开奖号码:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.openCodes + '</label></div>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">当期倍数:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.multiple + '</label></div>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">投注金额:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.amount + '</label></div>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">中奖金额:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.prize + '</label></div>');
                oPackages.push('<div data-role="fieldcontain"><label class="hl-detail-display-label">订单状态:</label>');
                oPackages.push('<label class="hl-detail-display-label">' + this.status + '</label></div>');
                oPackages.push('</li>');
            });
            $("#zhuihaoList").html(oPackages.join("")).listview('refresh');

            //withdraw button 撤单
            detail.wrap_id = data.trace.wrap_id;
            detail.pkids = pkids;
            if (cancel_status) {
                $("#withdraw").off("click").click(function() {
                    $("#withdrawPopup").popup("open");
                    //programmatically bind click event
                    $("#confirmWithdraw").off("click").click(function() {
                        detail.withdraw({'id': detail.id, 'trace_id': detail.trace_id, 'wrap_id': detail.wrap_id,
                            'pkids': detail.pkids});
                    });
                }).show();
            }

        }
        else if (data.package)
        {
            $(".hl-detail-normal").show();
            $(".hl-detail-cno").hide();
            $("#detailNumber").text(data.package.wrap_id);
            $("#detail_username").text(data.user.username);
            $("#detail_create_time").text(data.package.create_time);
            $("#detail_lottery").text(data.lottery.cname);
            $("#detail_issue").text(data.package.issue);
            $("#detail_single_num").text(data.package.single_num);
            $("#detail_multiple").text(data.package.multiple);
            $("#detail_modes").text(data.modes);
            $("#detail_is_trace").text(data.package.is_trace);
            $("#detail_amount").text(data.package.amount);
            $("#detail_prizeMode").text(data.prizeMode);
            $("#detail_openCodes").text(data.package.openCodes);
            $("#detail_status").text(data.package.status);
            $("#detail_prize").text(data.package.prize);
            //withdraw button 撤单
            detail.wrap_id = data.package.wrap_id;
            if (data.package.cancel_status == '0') {
                $("#withdraw").off("click").click(function() {
                    $("#withdrawPopup").popup("open");
                    //programmatically bind click event
                    $("#confirmWithdraw").off("click").click(function() {
                        detail.withdraw({'id': detail.id, 'trace_id': detail.trace_id, 'wrap_id': detail.wrap_id});
                    });
                }).show();
            }

        }
        $(".hl-detail-main").show();
    },
    //withdraw
    withdraw: function(id) {
        //show load
        $.mobile.loading('show');
        server.withdraw(id, function(data) {
            //hide load
            $.mobile.loading('hide');
            $(".hl-detail-main, #withdraw").hide();
            if (data.errno == '0') {
                alert(label.withdrawSuccess);
            }
            else {
                alert(data.errstr);
            }
            detail.init();
        });
    }
}

﻿/*---------------------------------------------------------------------------member--------------------------------------------------------------------------------------------------------*/
        ﻿//page before change event
        $(document).on('pagebeforechange', function(e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
                re = /^#member/;
        if (u.hash.search(re) !== -1) {
            var profile = cache.getProfile();
            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#member";
                e.preventDefault();
                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

//page before show event
$("#member").on('pagebeforeshow', function() {
    var profile = cache.getProfile();
    if (profile != null && profile.id.length > 0) {
        //clear
        $("#memberList").empty();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#member").on('pageshow', function() {
    //initialiaze
    member.init();
});

var member = {
    //init
    init: function() {
        member.render();
    },
    //render
    render: function() {
        var m = [];
        m.push('<li><a href="#accountSummary"><img src="css/images/ico-gold.png" /><h3>');
        m.push(label.account);
        //m.push('</h3><p>&nbsp;</p></a></li><li><a href="#accountWithdraw"><img src="css/images/ico-gold.png" /><h3>');
        //m.push(label.withdraw);
        m.push('</h3><p>&nbsp;</p></a></li><li><a href="#accountInquiry"><img src="css/images/ico-gold.png" /><h3>');
        m.push(label.inquiry);
        m.push('</h3><p>&nbsp;</p></a></li>');
        $("#memberList").html(m.join("")).listview('refresh', true);
    }
}

﻿/*---------------------------------------------------------------------------accountSummary--------------------------------------------------------------------------------------------------------*/
//page before change event
        $(document).on('pagebeforechange', function(e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage), re = /^#accountSummary/;
        if (u.hash.search(re) !== -1) {
            var profile = cache.getProfile();
            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#accountSummary";
                e.preventDefault();
                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

//page before show event
$("#accountSummary").on('pagebeforeshow', function() {
    var profile = cache.getProfile();
    if (profile != null && profile.id.length > 0) {
        //clear
        $("#accountList").empty();
        $(".hl-account-summary-container").hide();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#accountSummary").on('pageshow', function() {
    //initialiaze
    accountSummary.init();
});

//page init event
$('#accountSummary').on('pageinit', function(event) {

});

//refresh event
$(document).on('refresh', function(event, data) {
    if (data == "accountSummary") {
        accountSummary.search(true);
    }
});

var accountSummary = {
    //init
    init: function() {
        //clear content
        $("#accountList").empty();
        accountSummary.search(false);
    },
    //search
    search: function(showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('show');
        }

        var profile = cache.getProfile();

        server.getAccount(profile, function(data) {
            if (data != null) {
                //render
                accountSummary.render(data);
            }

            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    },
    //render
    render: function(data) {
        var a = [],
                s = [],
                accountLabel = "";

        //list
        s.push('<option value="">&nbsp;</option>');

        if (data.length > 0) {
            $.each(data, function(index) {
                accountLabel = utils.getAccountLabel(this.id);
                a.push('<li><div class="hl-account-type">');
                a.push(accountLabel);
                a.push('</div><div class="hl-account-bal" id="acct_' + this.aId + '">');
                a.push(utils.cny(this.val, 2));
                a.push('</div></li>');

                s.push('<option value="');
                s.push(this.aId);
                s.push('">');
                s.push(accountLabel);
                s.push('</option>');
            });
        }
        else {
            a.push('<li>');
            a.push(label.noRecord);
            a.push('</li>');
        }
        $("#accountList").empty().html(a.join("")).listview('refresh');
        $(".hl-account-summary-container").show();

    }


}

﻿/*---------------------------------------------------------------------------accountInquiry--------------------------------------------------------------------------------------------------------*/
//page before change event
        $(document).on('pagebeforechange', function(e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage), re = /^#accountInquiry/;
        if (u.hash.search(re) !== -1) {
            var profile = cache.getProfile();
            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#accountInquiry";

                e.preventDefault();

                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

//page before show event
$("#accountInquiry").on('pagebeforeshow', function() {
    var profile = cache.getProfile();

    if (profile != null && profile.id.length > 0) {
        //reset page number
        accountInquiry.pageNumber = 1;
        $(".hl-account-inquiry-title-container, #accountMoreContainer").hide();

        //clear
        $("#accountInquiryList").empty();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#accountInquiry").on('pageshow', function() {
    //initialiaze
    accountInquiry.init();
});

//page init event
$('#accountInquiry').on('pageinit', function(event) {
    $("#searchAccountList").change(function(event, ui) {
        //reset page number
        accountInquiry.pageNumber = 1;
        $(".hl-account-inquiry-title-container, #accountMoreContainer").hide();

        //clear
        $("#accountInquiryList").empty();

        accountInquiry.search(false);
    });

    $("#accountMoreLink").off("click").click(function() {
        //increase page number
        accountInquiry.pageNumber++;
        accountInquiry.search(false);
    });
});

//refresh event
$(document).on('refresh', function(event, data) {
    if (data == "accountInquiry") {
        //reset page number
        accountInquiry.pageNumber = 1;

        accountInquiry.search(true);
    }
});

var accountInquiry = {
    pageNumber: 1,
    //init
    init: function() {
        //clear
        $("#accountInquiryList").empty();
        accountInquiry.render();
    },
    //render
    render: function() {
        var data = cache.getProfile(),
                accountId = "",
                searchAccountList = $("#searchAccountList");

        if (data != null) {
            if (searchAccountList.html().length > 0) {
                accountInquiry.search(false);
            }
            else {
                var a = [],
                        accountLabel = "";

                $.each(data.a, function() {
                    accountLabel = utils.getAccountLabel(this.id);
                    if (accountLabel == null || accountLabel == '') {
                        return;
                    }
                    //set account id
                    if (accountId.length == 0) {
                        accountId = this.id;
                    }
                    a.push('<option value="');
                    a.push(this.id);
                    a.push('">');
                    a.push(accountLabel);
                    a.push('</option>');
                });

                searchAccountList.empty().html(a.join(""));
                //reset dropdown
                searchAccountList[0].selectedIndex = 0;
                searchAccountList.selectmenu("refresh", true);
                if (accountId.toString().length > 0) {
                    accountInquiry.search(false);
                }
            }
        }
    },
    //search
    search: function(showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('show');
        }
        var item = {};
        item.id = $("#searchAccountList").val();
        item.pageNumber = accountInquiry.pageNumber;
        item.pageSize = setting.search.pageSize;
        server.getAccountActivity(item, function(data) {
            if (data != null) {
                var s = [];
                if (data.r.length > 0) {
                    $.each(data.r, function(index) {
                        s.push('<li><div class="hl-account-inquiry"><div class="hl-account-inquiry-date">');
                        s.push(this.create_time);
                        s.push('</div><div class="hl-account-inquiry-txn ');
                        if (this.amount >= 0) {
                            s.push('hl-account-inquiry-txn-in');
                        }
                        else {
                            s.push('hl-account-inquiry-txn-out');
                        }
                        s.push('">');
                        s.push(utils.digits(this.amount, 2));
                        s.push('</div><div class="hl-account-inquiry-bal">');
                        s.push(utils.digits(this.balance, 2));
                        s.push('</div><div class="hl-account-inquiry-type">');
                        s.push(this.type);
                        s.push('</div></div></li>');
                    });
                }
                else {
                    s.push('<li>');
                    s.push(label.noRecord);
                    s.push('</div></li>');
                }

                if (showProgress) {
                    $("#accountInquiryList").html(s.join("")).listview('refresh');
                }
                else {
                    $("#accountInquiryList").append(s.join("")).listview('refresh');
                }

                //show title
                $(".hl-account-inquiry-title-container").show();

                //show or hide more button
                if (data.r.length > 0 && data.c > accountInquiry.pageNumber) {
                    $("#accountMoreContainer").show();
                }
                else {
                    $("#accountMoreContainer").hide();
                }

                if (showProgress) {
                    $(".dn-progress").hide();
                    $(".dn-refresh").show();
                }
                else {
                    //hide load
                    $.mobile.loading('hide');
                }
            }
        });
    }
}

﻿/*---------------------------------------------------------------------------accountWithdraw--------------------------------------------------------------------------------------------------------*/
//page before change event
        $(document).on('pagebeforechange', function(e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage), re = /^#accountWithdraw/;
        if (u.hash.search(re) !== -1) {
            var profile = cache.getProfile();
            if (profile == null || profile.id.length == 0) {
                //store next page url
                login.nextPage = "#accountWithdraw";
                e.preventDefault();
                $.mobile.changePage($("#login"), {
                    changeHash: false
                });
            }
        }
    }
});

//page before show event
$("#accountWithdraw").on('pagebeforeshow', function() {
    var profile = cache.getProfile();
    if (profile != null && profile.id.length > 0) {
        //clear
        $("#accountWithdrawMessage, #accountWithdrawBalance").text("");
        $("#txtWithdrawAmount, #txtAccountPassword").val("");
        $("#accountWithdrawFrom").empty();
        $(".hl-account-withdraw-container").hide();
    }
    else {
        $.mobile.changePage($("#login"), {
            changeHash: false
        });
    }
});

//page show event
$("#accountWithdraw").on('pageshow', function() {
    //initialiaze
    accountWithdraw.init();
});

//page init event
$('#accountWithdraw').on('pageinit', function(event) {
    $("#accountWithdrawLink").off("click").click(function() {
        accountWithdraw.withdraw();
    });
});

//page show event
$("#accountWithdraw").on('pageshow', function() {
    //initialiaze
    accountWithdraw.init();
});

//refresh event
$(document).on('refresh', function(event, data) {
    if (data == "accountWithdraw") {
        accountWithdraw.search(true);
    }
});

var accountWithdraw = {
    //init
    init: function() {
        //clear content
        $("#accountWithdrawMessage, #accountWithdrawBalance").text("");
        $("#txtWithdrawAmount, #txtAccountPassword").val("");
        $("#accountWithdrawFrom").empty();
        accountWithdraw.search(false);
    },
    //search
    search: function(showProgress) {
        if (showProgress) {
            $(".dn-refresh").hide();
            $(".dn-progress").show();
        }
        else {
            //show load
            $.mobile.loading('show');
        }
        var profile = cache.getProfile();
        server.getAccountWithdraw(profile, function(data) {
            //hide load
            $.mobile.loading('hide');
            if (data != null) {
                //render
                accountWithdraw.render(data);
            }
            if (showProgress) {
                $(".dn-progress").hide();
                $(".dn-refresh").show();
            }
            else {
                //hide load
                $.mobile.loading('hide');
            }
        });
    },
    //render
    render: function(data) {
        var s = [];
        s.push('<option value="">&nbsp;</option>');
        if (data.a.length > 0) {
            $.each(data.a, function(index) {
                s.push('<option value="');
                s.push(this.id);
                s.push('">');
                s.push(this.val);
                s.push('</option>');
            });
        }
        $("#accountWithdrawMessage").html(label.withdrawMessage.replace("{0}", data.mw).replace("{1}", data.cw));
        $("#accountWithdrawBalance").text(utils.cny(data.b, 2));
        //dropdown
        $("#accountWithdrawFrom").empty().html(s.join(""));
        $("#accountWithdrawFrom").selectmenu("refresh", true);
        $("#txtWithdrawAmount").val("");
        $("#txtAccountPassword").val("");
        $(".hl-account-withdraw-container").show();
    },
    //withdraw
    withdraw: function() {
        var detail = {};
        detail.amount = $("#txtWithdrawAmount").val();
        detail.account = $("#accountWithdrawFrom").val();
        detail.password = $("#txtAccountPassword").val();
        //show load
        $.mobile.loading('show');
        server.accountWithdraw(detail, function(data) {
            //hide load
            $.mobile.loading('hide');
            utils.prompt(label.withdrawCashSuccess, $("#accountWithdraw"),
                    function() {
                        accountWithdraw.search(false);
                    });
        });
    }
}

﻿/*---------------------------------------------------------------------------orderSelect--------------------------------------------------------------------------------------------------------*/
//page before change event
        $(document).on("pagebeforechange", function(e, data) {
    //use cache if available, otherwise read from url
    if (cache.getGame() == null) {
        if (typeof data.toPage === "string") {
            var u = $.mobile.path.parseUrl(data.toPage),
                    re = /^#orderSelect/;
            if (u.hash.search(re) !== -1) {
                //further check for query string
                if (u.hash.indexOf("?lottery=") != -1) {
                    cache.setGame(u.hash.replace(/.*lottery=/, ""));
                }
                else {
                    e.preventDefault();
                    $.mobile.changePage($("#cp"), {
                        changeHash: true
                    });
                }
            }
        }
    }
});

//page before show event
$("#orderSelect").on('pagebeforeshow', function() {
    //clear
    $("#numberList").empty();
    $("#orderCountdown").text("--:--:--");
    //reset cache
    orderSelect.resetDraw();
});

//page show event
$("#orderSelect").on('pageshow', function(e, data) {
    //initialiaze    
    orderSelect.init();
});

//page hide event
$("#orderSelect").on('pagehide', function(e, data) {
    //reset number
    orderSelect.resetNumber();
    orderSelect.resetCountdown();
});

//page init event
$('#orderSelect').on('pageinit', function(event) {
    $("#gameOptionList").change(function(event, ui) {
        orderSelect.renderNumber($(this).val());
    });

    $("#orderAuto").unbind("vclick").bind('vclick', function(e) {
        orderSelect.randomNumber();
    });

    $("#orderClear").unbind("vclick").bind('vclick', function(e) {
        orderSelect.resetNumber();
    });

    $("#orderCheck").unbind("click").bind('click', function(e) {
        orderSelect.confirmOrder();
    });
});

var orderSelect = {
    gameSubOption: null,
    number: {},
    gameType: null,
    //init
    init: function() {
        orderSelect.render();
        //start countdown
        orderConfirm.resetCountdown();
        orderSelect.setCountdown();
    },
    //render
    render: function() {
        var gameId = cache.getGame();
        if (gameId) {
            //header
            $("#orderTitle").text(utils.getGameLabel(gameId));
            //options
            var o = [], game = utils.getGameConfigsById(gameId);
            if (!isEmpty(game.gc)) {
                var gameConfig = game.gc,
                        configIndex = 0,
                        count = 0,
                        id = "",
                        optionLabel = "",
                        subOptionLabel = "";
                //set game type
                orderSelect.gameType = game.lottery_id;
                orderSelect.lotteryType = game.lotteryType;
                $.each(gameConfig.methods, function() {
                    optionLabel = this.mg_name;
                    //main options
                    o.push('<optgroup label="');
                    o.push(optionLabel);
                    o.push('">');
                    //sub options
                    $.each(this.childs, function() {
                        //不能输入的 不支持～～
                        if (!this.field_def || this.field_def.length == 0) {
                            return;
                        }
                        subOptionLabel = this.cname;
                        o.push('<option value="');
                        o.push(this.method_id);
                        o.push('">');
                        o.push(subOptionLabel);
                        o.push('</option>');
                        // 默认方法
                        if (gameConfig.lotteryType == 1) {
                            if (subOptionLabel == '后三直选' || subOptionLabel == 'P3直选')
                                configIndex = count;
                        } else if (gameConfig.lotteryType == 2) {
                            if (subOptionLabel == '任选' || subOptionLabel == '任选五中五')
                                configIndex = count;
                        } else if (gameConfig.lotteryType == 4) {
                            if (subOptionLabel == '直选')
                                configIndex = count;
                        }
                        count++;
                    });
                    o.push('</optgroup>');
                });
                $("#gameOptionList").empty().html(o.join(""));
                $("#gameOptionList")[0].selectedIndex = configIndex;
                $("#gameOptionList").selectmenu("refresh", true);
                //render default numbers
                orderSelect.renderNumber($("#gameOptionList").val());
            }

            //render history
            //$('#orderHistory').attr('href', '/?c=game&a=chart&lottery_id=' + orderSelect.gameType);
        }
    },
    //render numbers
    renderNumber: function(code) {
        var gameId = cache.getGame();
        var game = utils.getGameConfigsById(gameId);
        var gameConfig = game.gc;
        var subOption = {};
        $.each(gameConfig.methods, function() {
            $.each(this.childs, function() {
                if (this.method_id == code) {
                    subOption = this;
                }
            });
        });
        var className = 'hl-order-tab';
        // 特殊彩种
        //var  className = "hl-order-tab-hel";
        if (subOption) {
            //cache subOption
            orderSelect.gameSubOption = subOption;
            var n = [];
            for (var rowno in subOption.field_def) {
                n.push('<li data-role="fieldcontain"><fieldset data-role="controlgroup" data-type="horizontal"><legend class="hl-order-game-legend">');
                if (subOption.field_def[rowno].prompt) {
                    n.push(subOption.field_def[rowno].prompt);
                }
                else {
                    n.push("");
                }
                n.push('</legend><div class="hl-order-game-buttons ');
                n.push('">');
                var nums = subOption.field_def[rowno].nums.split(" ");
                for (var i = 0; i < nums.length; i++) {
                    n.push('<div id="gameButton');
                    n.push(i);
                    n.push('" row="' + rowno);
                    n.push('" class="' + className + ' hl-order-game-tab');
                    n.push('"><span class="hl-order-game-tab-button');
                    n.push('">');
                    n.push(nums[i]);
                    n.push('</span></div>');
                }
                n.push('</div></fieldset></li>');
            }
            $('#numberList').empty().html(n.join("")).listview('refresh');
            //bind events
            $('.hl-order-game-tab > span').bind('vclick', function(e) {
                e.preventDefault();
                var tab = $(this).parent();
                var id = tab.attr('row');
                if (tab.hasClass(className + "-selected")) {
                    tab.removeClass(className + "-selected");
                    //update number
                    orderSelect.updateNumber(id, $(this).text(), false)
                    orderSelect.updateOrder();
                }
                else {
                    if (tab.parent().find('.' + className + "-selected").length >= orderSelect.gameSubOption.field_def[id].max_selected) {
                        if (orderSelect.gameSubOption.field_def[id].max_selected == 1) {
                            orderSelect.updateNumber(id, tab.parent().find('.' + className + "-selected").text(), false);
                            tab.parent().find('.' + className + "-selected").removeClass(className + "-selected");
                            tab.addClass(className + "-selected");
                            orderSelect.updateNumber(id, $(this).text(), true);
                            orderSelect.updateOrder();
                        } else {
                            alert("当前最多只能选择" + orderSelect.gameSubOption.field_def[id].max_selected + "个号码");
                        }
                    } else {
                        tab.addClass(className + "-selected");
                        orderSelect.updateNumber(id, $(this).text(), true);
                        orderSelect.updateOrder();
                    }

                }

            });
        }
        //reset 
        orderSelect.resetNumber();
    },
    //reset number
    resetNumber: function() {
        $(".hl-order-game-tab").removeClass("hl-order-tab-selected");
        $(".hl-order-game-tab").removeClass("hl-order-tab-hel-selected");
        $(".hl-order-footer-text").text("");
        orderSelect.number = {};
    },
    //get number
    getNumber: function(id) {
        return orderSelect.number[id];
    },
    //update number
    updateNumber: function(id, number, add) {
        var numbers = orderSelect.getNumber(id);
        //create new number placeholder
        if (numbers == null || number == undefined) {
            orderSelect.number[id] = [];
            numbers = orderSelect.number[id];
        }
        //add or remove number
        if (add) {
            if (numbers.indexOf(number) == -1) {
                //only add when number does not exsit
                numbers.push(number);
            }
        }
        else {
            var index = -1;

            for (var i = 0; i < numbers.length; i++) {
                if (numbers[i] == number) {
                    index = i;
                    break;
                }
            }

            if (index > -1) {
                //remove
                numbers.splice(index, 1);
            }
        }
    },
    isLegalCode: function() {
        var result = true;
        for (var rowno in orderSelect.gameSubOption.field_def) {
            if (!orderSelect.number[rowno]) {
                result = false;
            }
        }
        return result;

    },
    //update order
    updateOrder: function() {
        var isLegalCode = orderSelect.isLegalCode();
        if (orderSelect.number && isLegalCode) {
            var codes = new Array();
            var bets = '';
            var arrindex = 0;
            for (var rowno in orderSelect.number) {
                if (bets != '') {
                    bets += ',';
                }
                if (orderSelect.lotteryType == 2 || orderSelect.gameSubOption.field_def[rowno].max_selected > 10) {
                    bets += (orderSelect.number[rowno]).join('_');
                }
                else {
                    bets += (orderSelect.number[rowno]).join('');
                }

                codes[arrindex] = orderSelect.number[rowno];
                arrindex++;
            }
            //只有一组的情况下格式不同
            if (arrindex == 1) {
                codes[0] = codes[0].join('_');
            }
            var betResult = utils.isLegalCode(codes, orderSelect.gameSubOption.name);
            var bets_total = betResult.singleNum;
            var totalOrder = [];
            totalOrder.push('号码: ');
            totalOrder.push('<span id="orderBet" class="hl-order-summary">');
            totalOrder.push(bets);
            totalOrder.push('</span>');
            totalOrder.push("，");
            totalOrder.push('<span id="orderTotal" class="hl-order-summary">');
            totalOrder.push(bets_total);
            totalOrder.push('</span> ');
            totalOrder.push('注');
            $(".hl-order-footer-text").html(totalOrder.join("")).show();
        }
        else {
            $(".hl-order-footer-text").html("").show();
        }
    },
    //confirm order
    confirmOrder: function() {
        //validation
        var isLegalCode = orderSelect.isLegalCode();

        if (isLegalCode) {
            //add number to bet collection

            var codes = '';
            for (var rowno in orderSelect.number) {
                if (codes != '') {
                    codes += ',';
                }
                if (orderSelect.lotteryType == 2 || orderSelect.gameSubOption.field_def[rowno].max_selected > 10) {
                    codes += (orderSelect.number[rowno]).join('_');
                }
                else {
                    codes += (orderSelect.number[rowno]).join('');
                }
            }
            var orderDetail = {
                subOption: orderSelect.gameSubOption.method_id,
                type: orderSelect.gameSubOption.cname,
                name: orderSelect.gameSubOption.name,
                number: orderSelect.number,
                codes: codes,
                bet: $("#orderBet").text(),
                total: $("#orderTotal").text(),
                unit: cache.getUnit(),
            };
            cache.addBet(orderDetail);
            //direct to order confirmation page
            $.mobile.changePage($("#orderConfirm"), {
                changeHash: true
            });
        }
        else {
            utils.alert(label.inCompleteGame, $("#orderSelect"));
        }
    },
    //set order number
    setOrderNumber: function(data) {

    },
    //random number
    randomNumber: function() {
        var max = $('#numberList span').length;
        $('#numberList span').each(function() {
            var random = Math.floor(Math.random() * max + 1);
            if (random > (max * 0.618))
                $(this).click();

        });

    },
    //set countdown
    setCountdown: function() {
        var gameId = cache.getGame();
        if (gameId) {
            server.getDraw(gameId, function(data) {
                if (data != null) {
                    //cache data
                    cache.setDraw(data);
                    //update title
                    $("#orderTitle").html(utils.getGameLabel(gameId) + '<span class="hl-order-period">' + data.curIssueInfo.issue + label.period + '</span>');
                    orderSelect.countDownTimer($("#orderCountdown"), data.curRemainTime);
                }
            });
        }
    },
    //reset countdown
    resetCountdown: function() {
        $("#orderCountdown").countdown('destroy');
    },
    //count down timer
    countDownTimer: function(gameTime, timestamp) {
        //timestamp = 999999;
        gameTime.countdown('destroy');
        gameTime.countdown({
            until: timestamp,
            format: "dHMS",
            compact: true,
            onExpiry: function() {
                utils.alert(label.drawDisable, $("#orderSelect"), orderSelect.setCountdown);
                //refresh countdown

            }
        });
    },
    //reset draw
    resetDraw: function() {
        cache.resetDraw();
    }
}

﻿/*---------------------------------------------------------------------------orderConfirm--------------------------------------------------------------------------------------------------------*/
//page before change event
        $(document).on('pagebeforechange', function(e, data) {
    if (typeof data.toPage === "string") {
        var u = $.mobile.path.parseUrl(data.toPage),
                re = /^#orderConfirm/;
        if (u.hash.search(re) !== -1) {
            var game = cache.getGame();
            if (game == null) {
                e.preventDefault();
                $.mobile.changePage($("#cp"), {
                    changeHash: true
                });
            }
        }
    }
});

//page before show event
$("#orderConfirm").on('pagebeforeshow', function() {
    //clear
    $("#orderList").empty();

    //reset draw
    $(".hl-order-confirm-bet-no").text("-");
});

//page show event
$("#orderConfirm").on('pageshow', function(e, data) {
    //initialiaze    
    orderConfirm.init();
});

//page hide event
$("#orderConfirm").on('pagehide', function(e, data) {
    orderConfirm.resetCountdown();
});
//page init event
$('#orderConfirm').on('pageinit', function(event) {
    $("input[name=unit]:radio").unbind("change").change(function() {
        //update summary
        orderConfirm.updateSummary();
    });

    $("#txtCno").unbind("keydown").keydown(function(event) {
        // prevent shift key since its not needed 
        if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ($(this).val().length >= 2 && !utils.isNavigationKey(event.keyCode)) {
            //$(this).val($(this).val().substr(0, 2));
            event.preventDefault();
        }
        else if (!utils.isValidBetNumber(event.keyCode)) {
            // prevent the rest 
            event.preventDefault();
        }
    }).unbind("change").change(function() {
        try {
            var m = parseInt($("#txtCno").val());

            if (m <= 0) {
                $("#txtCno").val("1");
            }
        } catch (E) {
            $("#txtCno").val("1");
        }
        cache.setBetSettingsCno(this.value);
        //update summary
        orderConfirm.updateSummary();
    });

    $("#txtMultiplier").unbind("keydown").keydown(function(event) {
        // prevent shift key since its not needed 
        if (event.shiftKey == true) {
            event.preventDefault();
        }
        if ($(this).val().length >= 4 && !utils.isNavigationKey(event.keyCode)) {
            //$(this).val($(this).val().substr(0, 4));
            event.preventDefault();
        }
        else if (!utils.isValidBetNumber(event.keyCode)) {
            // prevent the rest 
            event.preventDefault();
        }
    }).unbind("change").change(function() {
        try {
            var m = parseInt($("#txtMultiplier").val());
            if (m > 500) {
                m = 500;
                $("#txtMultiplier").val('500');
            }
            if (m <= 0) {
                $("#txtMultiplier").val("1");
            }
        } catch (E) {
            $("#txtMultiplier").val("1");
        }

        orderConfirm.updateSummary();
    });
    $("#txtMultiplierPlus").unbind("click").click(function(event) {
        try {
            var m = parseInt($("#txtMultiplier").val());
            $("#txtMultiplier").val((m + 1));
        } catch (E) {

        }
        $("#txtMultiplier").change();

    });

    $("#txtMultiplierMinus").unbind("click").click(function(event) {
        try {
            var m = parseInt($("#txtMultiplier").val());
            $("#txtMultiplier").val((m - 1));
        } catch (E) {

        }
        $("#txtMultiplier").change();
    });

    $("#orderConfirmOrder").unbind("click").click(function() {
        orderConfirm.placeOrder();
    });
});

var orderConfirm = {
    payoutStack: [],
    //init
    init: function() {
        var data = cache.getData();
        if (data == null) {
            server.getConfig(function(data) {
                if (data != null) {
                    //cache config
                    cache.setData(data);
                    //render
                    orderConfirm.render();
                    //start countdown
                    orderConfirm.resetCountdown();
                    orderConfirm.setCountdown();
                }
            });
        }
        else {
            orderConfirm.render();
            //start countdown
            orderConfirm.resetCountdown();
            orderConfirm.setCountdown();
        }
    },
    //render
    render: function() {
        var data = cache.getBet(),
                multiplier = 0,
                total = 0,
                o = [],
                amount = 0;
        if (data.length > 0) {
            $.each(data, function(i) {
                o.push('<li><div class="hl-order-confirm-label">');
                o.push(this.type);
                o.push('</div><div class="hl-order-confirm-number">');
                o.push(this.codes);
                o.push('  (共' + this.total + '注)');
                o.push('</div><div class="hl-order-confirm-data" number="');
                o.push(this.codes);
                o.push('" code="');
                o.push(this.subOption);
                o.push('" style="display:none"></div><div class="hl-order-confirm-delete">');
                o.push('<a href="#" data-role="button" data-mini="true" data-theme="d" i="');
                o.push(i.toString());
                o.push('">删除</a></div></li>');
                multiplier = multiplier + parseInt(this.total);
                //convert to 元
                amount = this.total * 2;
                total = total + amount;

            });
        }
        else {
            o.push('<li><span class="hl-order-confirm-no-record">');
            o.push(label.noRecord);
            o.push('<span></li>');
        }
        $('#orderList').empty().html(o.join("")).listview('refresh');
        $('.hl-order-confirm-delete > a').button().click(function() {
            var index = $(this).attr("i");
            //remove from cache
            cache.removeBet(index);
            //refresh
            orderConfirm.render();
        });
        //settings
        var betSettings = cache.getBetSettings();
        //彩种
        $(".hl-order-confirm-game").text(utils.getGameLabel(cache.getGame()));
        //倍数
        $("#txtMultiplier").val(betSettings.multiplier);
        //追号
        $("#txtCno").val(betSettings.cno);
        var gapList = orderConfirm.generateGapList();
        var defaultGapPos = 50;
        var defaultGap = orderConfirm.getMode(defaultGapPos);
        var sliderHtml = '';
        var tmpSelectThis = 0;
        $.each(gapList, function(i) {

            if (defaultGap.rebate == this.rebate) {
                tmpSelectThis = i;
            }
            sliderHtml += '<option value="' + this.rebate + '" ' + tmpSelectThis + '>' + this.prize + '/' + number_format(this.rebate * 100, 2) + '</option>';
        })
        $("#slider").empty().html(sliderHtml);
        $("#slider")[0].selectedIndex = tmpSelectThis;
        $("#slider").selectmenu("refresh", true);


        //当前模式
        //   $(".hl-order-mode").text(defaultGap.prize + '/' + number_format(defaultGap.rebate * 100, 2));
//        $("#slider").off("slidestop").off("change").attr("min", 1).attr("max", 100).val(defaultGapPos).slider('refresh');
//        //slider event
//        $("#slider").change(function() {
//            var gap = orderConfirm.getMode(this.value);
//            $(".hl-order-mode").text(gap.prize + '/' + number_format(gap.rebate * 100, 2));
//        }).on("slidestop", function() {
//            var gap = orderConfirm.getMode(this.value);
//            $(".hl-order-mode").text(gap.prize + '/' + number_format(gap.rebate * 100, 2));
//        });
        //元角分模式
        //$(".hl-order-confirm-unit").attr("checked", false).checkboxradio("refresh");
        //$("#unit" + memberSettings.u).attr("checked", true).checkboxradio("refresh");

        //单倍注数
        $("#lblMultiplier").text(multiplier);

        //合计
        $("#lblTotal").attr("val", total);
        orderConfirm.updateSummary();
        $("#txtMultiplier").blur();
    },
    //get number display
    getNumberDisplay: function(type, number) {
        var bets = '';
        for (var rowno in number) {
            if (bets != '') {
                bets += ',';
            }
            bets += (number[rowno]).join('_');
        }
        return bets;
    },
    //update summary
    updateSummary: function() {
        var total = $("#lblTotal").attr("val"),
                multiplier = utils.parseFloat($("#txtMultiplier").val()),
                cno = utils.parseFloat($("#txtCno").val());
        total = $("input[name=unit]:checked").val() * total * (multiplier * cno);
        $("#lblTotal").text(label.symbol + total.toFixed(2));
    },
    //place order
    placeOrder: function() {
        var data = cache.getBet();
        //make sure there are order
        if (data.length > 0) {
            //verify cno and multiplier
            if ($("#txtCno").val().length > 0) {
                if ($("#txtMultiplier").val().length > 0) {

                    $("#orderConfirmSummary").text(label.confirmOrders);
                    var message = label.confirmOrders.replace("{0}", $("#lblTotal").text().replace("￥", ""));
                    utils.confirm(message, $("#orderConfirm"),
                            function() {
                                var profile = cache.getProfile();

                                if (profile == null || profile.id.length == 0) {
                                    //store next page url
                                    login.nextPage = "#orderConfirm";

                                    $.mobile.changePage($("#login"), {
                                        changeHash: false
                                    });
                                }
                                else {
                                    //show load
                                    $.mobile.loading('show');
                                    orderDetail = {};
                                    orderDetail.data = data;
                                    orderDetail.cno = $("#txtCno").val();
                                    orderDetail.multiplier = $("#txtMultiplier").val();
                                    orderDetail.curRebate = $("#slider").val();
                                    orderDetail.modes = $("input[name=unit]:checked").val();
                                    orderDetail.lotteryId = orderSelect.gameType;
                                    orderDetail.issue = cache.getDraw().curIssueInfo.issue;
                                    orderDetail.stopOnWin = $('#withdrawlWin').attr("checked") ? '1' : '0';
                                    server.saveOrder(orderDetail, function(data) {
                                        //hide load
                                        $.mobile.loading('hide');
                                        if (data) {
                                            orderConfirm.resetBet();

                                            utils.prompt(label.orderSuccess.replace("{0}", data.no).replace("{1}", $("#lblTotal").text().replace("￥", "")),
                                                    $("#orderConfirm"),
                                                    function() {
                                                        $.mobile.changePage($("#orderSelect"), {
                                                            changeHash: true
                                                        });
                                                    });
                                        }
                                    });

                                }
                            }, null);
                }
                else {
                    utils.alert(label.invalidMultiplier, $("#orderConfirm"));
                }
            }
            else {
                utils.alert(label.invalidCno, $("#orderConfirm"));
            }
        }
        else {
            utils.alert(label.noOrder, $("#orderConfirm"));
        }
    },
    //set countdown
    setCountdown: function() {
        var gameId = cache.getGame();
        if (gameId) {
            server.getDraw(gameId, function(data) {
                if (data != null) {
                    //cache data
                    cache.setDraw(data);
                    $(".hl-order-confirm-bet-no").text(cache.getDraw().curIssueInfo.issue);
                    orderConfirm.countDownTimer($("#orderConfirmCountdown"), data.curRemainTime);
                }
            });
        }
    },
    //reset countdown
    resetCountdown: function() {
        $("#orderConfirmCountdown").countdown('destroy');
    },
    //count down timer
    countDownTimer: function(gameTime, timestamp) {
        //set display
        gameTime.countdown('destroy');
        gameTime.countdown({
            until: timestamp,
            format: "dHMS",
            compact: true,
            onExpiry: function() {
                utils.alert(label.drawDisable, $("#orderConfirm"), orderConfirm.setCountdown);
            }
        });
    },
    //reset bet
    resetBet: function() {
        cache.clearBet();
    },
    getMode: function(pos) {
        if (!pos) {
            pos = 50;
        }
        var gapList = orderConfirm.generateGapList();
        var gap = gapList[parseInt(gapList.length * (pos / 100))];

        return gap;
    },
    generateGapList: function() {
        var gameId = cache.getGame();
        var game = utils.getGameConfigsById(gameId);
        var gameConfig = game.gc;
        var result = [];
        $.each(gameConfig.minRebateGaps,
                function(k, v) {
                    v.from = parseFloat(v.from);
                    v.to = parseFloat(v.to);
                    v.gap = parseFloat(v.gap);
                    if (gameConfig.rebate > v.to) {
                        for (var i = v.from; i <= v.to; i += v.gap) {
                            result.push(parseFloat(number_format(i, 3)));
                        }
                    } else {
                        for (i = v.from; i < v.to && i < gameConfig.rebate; i += v.gap) {
                            result.push(parseFloat(number_format(i, 3)))
                        }
                        result.push(parseFloat(number_format(gameConfig.rebate, 3)));
                    }
                });
        result = array_unique(result);
        var result2 = [];
        $.each(result,
                function(k, v) {
                    var prize = round(gameConfig.maxCombPrize * ((gameConfig.lotteryType == 1 ? 0.9 : 0.9) + v), 0);
                    result2.push({
                        rebate: round(gameConfig.rebate - v, 3),
                        prize: prize
                    })
                });
        return result2;
    }
}

﻿/*---------------------------------------------------------------------------test--------------------------------------------------------------------------------------------------------*/

//page before change event
//$(document).on('pagebeforechange', function(e, data) {
//    console.log(e);
//    console.log(data);
//});