# PHP collections comparison

### Memory performance

#### Items in collection: 0
| type                  | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|-----------------------|-------------------------|-------------------|-------------------------|
| array(count: 0)       | 0                       | 336               | 0                       |
| psalm(count: 0)       | 1,510                   | 544               | 240                     |
| monomorphic(count: 0) | 1,528                   | 544               | 240                     |
| type-erased(count: 0) | 1,512                   | 544               | 240                     |

#### Items in collection: 100
| type                    | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|-------------------------|-------------------------|-------------------|-------------------------|
| array(count: 100)       | 0                       | 7,728             | 12,248                  |
| psalm(count: 100)       | 1,510                   | 7,936             | 12,432                  |
| monomorphic(count: 100) | 1,528                   | 7,936             | 12,432                  |
| type-erased(count: 100) | 1,512                   | 7,936             | 12,432                  |

#### Items in collection: 1000
| type                     | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|--------------------------|-------------------------|-------------------|-------------------------|
| array(count: 1000)       | 0                       | 72,464            | 76,920                  |
| psalm(count: 1000)       | 1,510                   | 72,672            | 77,104                  |
| monomorphic(count: 1000) | 1,528                   | 72,672            | 77,104                  |
| type-erased(count: 1000) | 1,512                   | 72,672            | 77,104                  |

#### Items in collection: 10000
| type                      | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|---------------------------|-------------------------|-------------------|-------------------------|
| array(count: 10000)       | 0                       | 822,224           | 1,051,320               |
| psalm(count: 10000)       | 1,510                   | 822,432           | 1,051,560               |
| monomorphic(count: 10000) | 1,528                   | 822,432           | 1,051,560               |
| type-erased(count: 10000) | 1,512                   | 822,432           | 1,051,560               |

### Speed performance

```bash
PHPBench (1.2.3) running benchmarks...
with configuration file: /app/phpbench.json
with PHP version 8.1.3, xdebug ❌, opcache ❌

\App\Tests\TypHintBench

    benchWithoutType........................R1 I6 - Mo240.713μs (±0.47%)
    benchWithArrayType......................R1 I70 - Mo247.663μs (±0.45%)
    benchWithMixedType......................R2 I59 - Mo249.293μs (±0.54%)
    benchWithClassType......................R1 I26 - Mo306.533μs (±0.48%)

Subjects: 4, Assertions: 0, Failures: 0, Errors: 0
+--------------+--------------------+-----+------+-----+-----------+-----------+--------+
| benchmark    | subject            | set | revs | its | mem_peak  | mode      | rstdev |
+--------------+--------------------+-----+------+-----+-----------+-----------+--------+
| TypHintBench | benchWithoutType   |     | 1000 | 100 | 674.272kb | 240.713μs | ±0.47% |
| TypHintBench | benchWithArrayType |     | 1000 | 100 | 674.272kb | 247.663μs | ±0.45% |
| TypHintBench | benchWithMixedType |     | 1000 | 100 | 674.272kb | 249.293μs | ±0.54% |
| TypHintBench | benchWithClassType |     | 1000 | 100 | 674.272kb | 306.533μs | ±0.48% |
+--------------+--------------------+-----+------+-----+-----------+-----------+--------+
```

### How to reproduce
```bash
git clone git@github.com:mrsuh/php-collections-comparison.git && cd php-collections-comparison
docker build -t php-collections-comparison-image .
docker run -it --rm php-collections-comparison-image php bin/memory-test.php
docker run -it --rm php-collections-comparison-image php vendor/bin/phpbench run tests --report=aggregate
```
