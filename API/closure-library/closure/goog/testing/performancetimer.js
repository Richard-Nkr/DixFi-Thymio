/**
 * @license
 * Copyright The Closure Library Authors.
 * SPDX-License-Identifier: Apache-2.0
 */

/**
 * @fileoverview Performance timer.
 *
 * {@see goog.testing.benchmark} for an easy way to use this functionality.
 */

goog.setTestOnly('goog.testing.PerformanceTimer');
goog.provide('goog.testing.PerformanceTimer');
goog.provide('goog.testing.PerformanceTimer.Task');

goog.require('goog.array');
goog.require('goog.async.Deferred');
goog.require('goog.math');



/**
 * Creates a performance timer that runs test functions a number of times to
 * generate timing samples, and provides performance statistics (minimum,
 * maximum, average, and standard deviation).
 * @param {number=} opt_numSamples Number of times to run the test function;
 *     defaults to 10.
 * @param {number=} opt_timeoutInterval Number of milliseconds after which the
 *     test is to be aborted; defaults to 5 seconds (5,000ms).
 * @constructor
 */
goog.testing.PerformanceTimer = function(opt_numSamples, opt_timeoutInterval) {
  'use strict';
  /**
   * Number of times the test function is to be run; defaults to 10.
   * @private {number}
   */
  this.numSamples_ = opt_numSamples || 10;

  /**
   * Number of milliseconds after which the test is to be aborted; defaults to
   * 5,000ms.
   * @private {number}
   */
  this.timeoutInterval_ = opt_timeoutInterval || 5000;

  /**
   * Whether to discard outliers (i.e. the smallest and the largest values)
   * from the sample set before computing statistics.  Defaults to false.
   * @private {boolean}
   */
  this.discardOutliers_ = false;
};


/**
 * A function whose subsequent calls differ in milliseconds. Used to calculate
 * the start and stop checkpoint times for runs. Note that high performance
 * timers do not necessarily return the current time in milliseconds.
 * @return {number}
 * @private
 */
goog.testing.PerformanceTimer.now_ = function() {
  'use strict';
  // goog.now is used in DEBUG mode to make the class easier to test.
  return !goog.DEBUG && window.performance && window.performance.now ?
      window.performance.now() :
      goog.now();
};


/**
 * @return {number} The number of times the test function will be run.
 */
goog.testing.PerformanceTimer.prototype.getNumSamples = function() {
  'use strict';
  return this.numSamples_;
};


/**
 * Sets the number of times the test function will be run.
 * @param {number} numSamples Number of times to run the test function.
 */
goog.testing.PerformanceTimer.prototype.setNumSamples = function(numSamples) {
  'use strict';
  this.numSamples_ = numSamples;
};


/**
 * @return {number} The number of milliseconds after which the test times out.
 */
goog.testing.PerformanceTimer.prototype.getTimeoutInterval = function() {
  'use strict';
  return this.timeoutInterval_;
};


/**
 * Sets the number of milliseconds after which the test times out.
 * @param {number} timeoutInterval Timeout interval in ms.
 */
goog.testing.PerformanceTimer.prototype.setTimeoutInterval = function(
    timeoutInterval) {
  'use strict';
  this.timeoutInterval_ = timeoutInterval;
};


/**
 * Sets whether to ignore the smallest and the largest values when computing
 * stats.
 * @param {boolean} discard Whether to discard outlier values.
 */
goog.testing.PerformanceTimer.prototype.setDiscardOutliers = function(discard) {
  'use strict';
  this.discardOutliers_ = discard;
};


/**
 * @return {boolean} Whether outlier values are discarded prior to computing
 *     stats.
 */
goog.testing.PerformanceTimer.prototype.isDiscardOutliers = function() {
  'use strict';
  return this.discardOutliers_;
};


/**
 * Executes the test function the required number of times (or until the
 * test run exceeds the timeout interval, whichever comes first).  Returns
 * an object containing the following:
 * <pre>
 *   {
 *     'average': average execution time (ms)
 *     'count': number of executions (may be fewer than expected due to timeout)
 *     'maximum': longest execution time (ms)
 *     'minimum': shortest execution time (ms)
 *     'standardDeviation': sample standard deviation (ms)
 *     'total': total execution time (ms)
 *   }
 * </pre>
 *
 * @param {Function} testFn Test function whose performance is to
 *     be measured.
 * @return {!Object} Object containing performance stats.
 */
goog.testing.PerformanceTimer.prototype.run = function(testFn) {
  'use strict';
  return this.runTask(new goog.testing.PerformanceTimer.Task(
      /** @type {goog.testing.PerformanceTimer.TestFunction} */ (testFn)));
};


/**
 * Executes the test function of the specified task as described in
 * `run`. In addition, if specified, the set up and tear down functions of
 * the task are invoked before and after each invocation of the test function.
 * @see goog.testing.PerformanceTimer#run
 * @param {goog.testing.PerformanceTimer.Task} task A task describing the test
 *     function to invoke.
 * @return {!Object} Object containing performance stats.
 */
goog.testing.PerformanceTimer.prototype.runTask = function(task) {
  'use strict';
  var samples = [];
  var testStart = goog.testing.PerformanceTimer.now_();
  var totalRunTime = 0;

  var testFn = task.getTest();
  var setUpFn = task.getSetUp();
  var tearDownFn = task.getTearDown();

  for (var i = 0; i < this.numSamples_ && totalRunTime <= this.timeoutInterval_;
       i++) {
    setUpFn();
    var sampleStart = goog.testing.PerformanceTimer.now_();
    testFn();
    var sampleEnd = goog.testing.PerformanceTimer.now_();
    tearDownFn();
    samples[i] = sampleEnd - sampleStart;
    totalRunTime = sampleEnd - testStart;
  }

  return this.finishTask_(samples);
};


/**
 * Finishes the run of a task by creating a result object from samples, in the
 * format described in `run`.
 * @see goog.testing.PerformanceTimer#run
 * @param {!Array<number>} samples The samples to analyze.
 * @return {!Object} Object containing performance stats.
 * @private
 */
goog.testing.PerformanceTimer.prototype.finishTask_ = function(samples) {
  'use strict';
  if (this.discardOutliers_ && samples.length > 2) {
    goog.array.remove(samples, Math.min.apply(null, samples));
    goog.array.remove(samples, Math.max.apply(null, samples));
  }

  return goog.testing.PerformanceTimer.createResults(samples);
};


/**
 * Executes the test function of the specified task asynchronously. The test
 * function is expected to take a callback as input and has to call it to signal
 * that it's done. In addition, if specified, the setUp and tearDown functions
 * of the task are invoked before and after each invocation of the test
 * function. Note that setUp/tearDown functions take a callback as input and
 * must call this callback when they are done.
 * @see goog.testing.PerformanceTimer#run
 * @param {goog.testing.PerformanceTimer.Task} task A task describing the test
 *     function to invoke.
 * @return {!goog.async.Deferred} The deferred result, eventually an object
 *     containing performance stats.
 */
goog.testing.PerformanceTimer.prototype.runAsyncTask = function(task) {
  'use strict';
  var samples = [];
  var testStart = goog.testing.PerformanceTimer.now_();

  var testFn = task.getTest();
  var setUpFn = task.getSetUp();
  var tearDownFn = task.getTearDown();

  // Note that this uses a separate code path from runTask() because
  // implementing runTask() in terms of runAsyncTask() could easily cause
  // a stack overflow if there are many iterations.
  var result = new goog.async.Deferred();
  this.runAsyncTaskSample_(
      testFn, setUpFn, tearDownFn, result, samples, testStart);
  return result;
};


/**
 * Runs a task once, waits for the test function to complete asynchronously
 * and starts another run if not enough samples have been collected. Otherwise
 * finishes this task.
 * @param {goog.testing.PerformanceTimer.TestFunction} testFn The test function.
 * @param {goog.testing.PerformanceTimer.TestFunction} setUpFn The set up
 *     function that will be called once before the test function is run.
 * @param {goog.testing.PerformanceTimer.TestFunction} tearDownFn The set up
 *     function that will be called once after the test function completed.
 * @param {!goog.async.Deferred} result The deferred result, eventually an
 *     object containing performance stats.
 * @param {!Array<number>} samples The time samples from all runs of the test
 *     function so far.
 * @param {number} testStart The timestamp when the first sample was started.
 * @private
 */
goog.testing.PerformanceTimer.prototype.runAsyncTaskSample_ = function(
    testFn, setUpFn, tearDownFn, result, samples, testStart) {
  'use strict';
  var timer = this;
  timer.handleOptionalDeferred_(setUpFn, function() {
    'use strict';
    var sampleStart = goog.testing.PerformanceTimer.now_();
    timer.handleOptionalDeferred_(testFn, function() {
      'use strict';
      var sampleEnd = goog.testing.PerformanceTimer.now_();
      timer.handleOptionalDeferred_(tearDownFn, function() {
        'use strict';
        samples.push(sampleEnd - sampleStart);
        var totalRunTime = sampleEnd - testStart;
        if (samples.length < timer.numSamples_ &&
            totalRunTime <= timer.timeoutInterval_) {
          timer.runAsyncTaskSample_(
              testFn, setUpFn, tearDownFn, result, samples, testStart);
        } else {
          result.callback(timer.finishTask_(samples));
        }
      });
    });
  });
};


/**
 * Return the median of the samples.
 * @param {!Array<number>} samples
 * @return {number}
 */
goog.testing.PerformanceTimer.median = function(samples) {
  'use strict';
  samples.sort(function(a, b) {
    'use strict';
    return a - b;
  });
  let half = Math.floor(samples.length / 2);
  if (samples.length % 2) {
    return samples[half];
  } else {
    return (samples[half - 1] + samples[half]) / 2.0;
  }
};


/**
 * Execute a function that optionally returns a deferred object and continue
 * with the given continuation function only once the deferred object has a
 * result.
 * @param {goog.testing.PerformanceTimer.TestFunction} deferredFactory The
 *     function that optionally returns a deferred object.
 * @param {function()} continuationFunction The function that should be called
 *     after the optional deferred has a result.
 * @private
 */
goog.testing.PerformanceTimer.prototype.handleOptionalDeferred_ = function(
    deferredFactory, continuationFunction) {
  'use strict';
  var deferred = deferredFactory();
  if (deferred) {
    deferred.addCallback(continuationFunction);
  } else {
    continuationFunction();
  }
};


/**
 * Creates a performance timer results object by analyzing a given array of
 * sample timings.
 * @param {!Array<number>} samples The samples to analyze.
 * @return {!Object} Object containing performance stats.
 */
goog.testing.PerformanceTimer.createResults = function(samples) {
  'use strict';
  return {
    'average': goog.math.average.apply(null, samples),
    'count': samples.length,
    'median': goog.testing.PerformanceTimer.median(samples),
    'maximum': Math.max.apply(null, samples),
    'minimum': Math.min.apply(null, samples),
    'standardDeviation': goog.math.standardDeviation.apply(null, samples),
    'total': goog.math.sum.apply(null, samples)
  };
};


/**
 * A test function whose performance should be measured or a setUp/tearDown
 * function. It may optionally return a deferred object. If it does so, the
 * test harness will assume the function is asynchronous and it must signal
 * that it's done by setting an (empty) result on the deferred object. If the
 * function doesn't return anything, the test harness will assume it's
 * synchronous.
 * @typedef {function():(goog.async.Deferred|undefined)}
 */
goog.testing.PerformanceTimer.TestFunction;



/**
 * A task for the performance timer to measure. Callers can specify optional
 * setUp and tearDown methods to control state before and after each run of the
 * test function.
 * @param {goog.testing.PerformanceTimer.TestFunction} test Test function whose
 *     performance is to be measured.
 * @constructor
 * @final
 */
goog.testing.PerformanceTimer.Task = function(test) {
  'use strict';
  /**
   * The test function to time.
   * @type {goog.testing.PerformanceTimer.TestFunction}
   * @private
   */
  this.test_ = test;
};


/**
 * An optional set up function to run before each invocation of the test
 * function.
 * @type {goog.testing.PerformanceTimer.TestFunction}
 * @private
 */
goog.testing.PerformanceTimer.Task.prototype.setUp_ = goog.nullFunction;


/**
 * An optional tear down function to run after each invocation of the test
 * function.
 * @type {goog.testing.PerformanceTimer.TestFunction}
 * @private
 */
goog.testing.PerformanceTimer.Task.prototype.tearDown_ = goog.nullFunction;


/**
 * @return {goog.testing.PerformanceTimer.TestFunction} The test function to
 *     time.
 */
goog.testing.PerformanceTimer.Task.prototype.getTest = function() {
  'use strict';
  return this.test_;
};


/**
 * Specifies a set up function to be invoked before each invocation of the test
 * function.
 * @param {goog.testing.PerformanceTimer.TestFunction} setUp The set up
 *     function.
 * @return {!goog.testing.PerformanceTimer.Task} This task.
 */
goog.testing.PerformanceTimer.Task.prototype.withSetUp = function(setUp) {
  'use strict';
  this.setUp_ = setUp;
  return this;
};


/**
 * @return {goog.testing.PerformanceTimer.TestFunction} The set up function or
 *     the default no-op function if none was specified.
 */
goog.testing.PerformanceTimer.Task.prototype.getSetUp = function() {
  'use strict';
  return this.setUp_;
};


/**
 * Specifies a tear down function to be invoked after each invocation of the
 * test function.
 * @param {goog.testing.PerformanceTimer.TestFunction} tearDown The tear down
 *     function.
 * @return {!goog.testing.PerformanceTimer.Task} This task.
 */
goog.testing.PerformanceTimer.Task.prototype.withTearDown = function(tearDown) {
  'use strict';
  this.tearDown_ = tearDown;
  return this;
};


/**
 * @return {goog.testing.PerformanceTimer.TestFunction} The tear down function
 *     or the default no-op function if none was specified.
 */
goog.testing.PerformanceTimer.Task.prototype.getTearDown = function() {
  'use strict';
  return this.tearDown_;
};