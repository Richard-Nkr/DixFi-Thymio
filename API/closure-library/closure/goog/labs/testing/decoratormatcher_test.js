/**
 * @license
 * Copyright The Closure Library Authors.
 * SPDX-License-Identifier: Apache-2.0
 */

goog.module('goog.labs.testing.decoratorMatcherTest');
goog.setTestOnly();

/** @suppress {extraRequire} */
const AnythingMatcher = goog.require('goog.labs.testing.AnythingMatcher');
/** @suppress {extraRequire} */
const GreaterThanMatcher = goog.require('goog.labs.testing.GreaterThanMatcher');
const MatcherError = goog.require('goog.labs.testing.MatcherError');
const assertThat = goog.require('goog.labs.testing.assertThat');
const testSuite = goog.require('goog.testing.testSuite');

testSuite({
  testAnythingMatcher() {
    assertThat(true, anything(), 'anything matches true');
    assertThat(false, anything(), 'false matches anything');
  },

  testIs() {
    assertThat(5, is(greaterThan(4)), '5 is > 4');
  },

  testDescribedAs() {
    const e = assertThrows(() => {
      assertThat(4, describedAs('this is a test', greaterThan(6)));
    });
    assertTrue(e instanceof MatcherError);
    assertEquals('this is a test', e.message);
  },
});
