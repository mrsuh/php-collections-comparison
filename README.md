# PHP collections comparison

### Memory performance

#### Items in collection: 0
| type                  | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|-----------------------|-------------------------|-------------------|-------------------------|
| array(count: 0)       | 0                       | 336               | 0                       |
| annotation(count: 0)  | 1515                    | 544               | 240                     |
| monomorphic(count: 0) | 1528                    | 544               | 240                     |
| type-erased(count: 0) | 1512                    | 544               | 240                     |

#### Items in collection: 100
| type                    | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|-------------------------|-------------------------|-------------------|-------------------------|
| array(count: 100)       | 0                       | 7728              | 12248                   |
| annotation(count: 100)  | 1515                    | 7936              | 12432                   |
| monomorphic(count: 100) | 1528                    | 7936              | 12432                   |
| type-erased(count: 100) | 1512                    | 7936              | 12432                   |

#### Items in collection: 1000
| type                     | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|--------------------------|-------------------------|-------------------|-------------------------|
| array(count: 1000)       | 0                       | 72464             | 76920                   |
| annotation(count: 1000)  | 1515                    | 72672             | 77104                   |
| monomorphic(count: 1000) | 1528                    | 72672             | 77104                   |
| type-erased(count: 1000) | 1512                    | 72672             | 77104                   |

#### Items in collection: 10000
| type                      | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|---------------------------|-------------------------|-------------------|-------------------------|
| array(count: 10000)       | 0                       | 822224            | 1051320                 |
| annotation(count: 10000)  | 1515                    | 822432            | 1051560                 |
| monomorphic(count: 10000) | 1528                    | 822432            | 1051560                 |
| type-erased(count: 10000) | 1512                    | 822432            | 1051560                 |


### Speed performance

```bash
PHPBench (1.2.3) running benchmarks...
with configuration file: /app/phpbench.json
with PHP version 8.1.3, xdebug ❌, opcache ❌

\App\Tests\TypHintBench

    benchWithoutType........................R1 I19 - Mo273.894μs (±0.43%)
    benchWithArrayType......................R1 I12 - Mo262.648μs (±0.45%)
    benchWithClassType......................R1 I57 - Mo314.469μs (±0.48%)
    benchWithMixedType......................R1 I96 - Mo289.568μs (±0.41%)

Subjects: 4, Assertions: 0, Failures: 0, Errors: 0
+--------------+--------------------+-----+------+-----+-----------+-----------+--------+
| benchmark    | subject            | set | revs | its | mem_peak  | mode      | rstdev |
+--------------+--------------------+-----+------+-----+-----------+-----------+--------+
| TypHintBench | benchWithoutType   |     | 1000 | 100 | 674.272kb | 273.894μs | ±0.43% |
| TypHintBench | benchWithArrayType |     | 1000 | 100 | 674.272kb | 262.648μs | ±0.45% |
| TypHintBench | benchWithClassType |     | 1000 | 100 | 674.272kb | 314.469μs | ±0.48% |
| TypHintBench | benchWithMixedType |     | 1000 | 100 | 674.272kb | 289.568μs | ±0.41% |
+--------------+--------------------+-----+------+-----+-----------+-----------+--------+
```

### How to reproduce
```bash
git clone mrsuh/php-generics-comparison && cd php-generics-comparison
docker build -t generics-test-image .
docker run -it --rm generics-test-image php bin/memory-test.php
docker run -it --rm generics-test-image php vendor/bin/phpbench run tests --report=aggregate
```
