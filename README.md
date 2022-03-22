# PHP collections comparison

### Memory performance

#### Items in collection: 0
| type                  | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|-----------------------|-------------------------|-------------------|-------------------------|
| array(count: 0)       | 0                       | 336               | 0                       |
| psalm(count: 0)       | 1510                    | 544               | 240                     |
| monomorphic(count: 0) | 1528                    | 544               | 240                     |
| type-erased(count: 0) | 1512                    | 544               | 240                     |

#### Items in collection: 100
| type                    | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|-------------------------|-------------------------|-------------------|-------------------------|
| array(count: 100)       | 0                       | 7728              | 12248                   |
| psalm(count: 100)       | 1510                    | 7936              | 12432                   |
| monomorphic(count: 100) | 1528                    | 7936              | 12432                   |
| type-erased(count: 100) | 1512                    | 7936              | 12432                   |

#### Items in collection: 1000
| type                     | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|--------------------------|-------------------------|-------------------|-------------------------|
| array(count: 1000)       | 0                       | 72464             | 76920                   |
| psalm(count: 1000)       | 1510                    | 72672             | 77104                   |
| monomorphic(count: 1000) | 1528                    | 72672             | 77104                   |
| type-erased(count: 1000) | 1512                    | 72672             | 77104                   |

#### Items in collection: 10000
| type                      | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|---------------------------|-------------------------|-------------------|-------------------------|
| array(count: 10000)       | 0                       | 822224            | 1051320                 |
| psalm(count: 10000)       | 1510                    | 822432            | 1051560                 |
| monomorphic(count: 10000) | 1528                    | 822432            | 1051560                 |
| type-erased(count: 10000) | 1512                    | 822432            | 1051560                 |



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
