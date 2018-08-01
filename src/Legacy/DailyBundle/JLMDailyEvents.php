<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
final class JLMDailyEvents
{
	const INTERVENTION_SCHEDULEWORK = 'jlm_daily.intervention_schedulework';
	const INTERVENTION_UNSCHEDULEWORK = 'jlm_daily.intervention_unschedulework';
	const WORK_POSTPERSIST = 'jlm_daily.work_postpersist';
	const WORK_POSTUPDATE = 'jlm_daily.work_postupdate';
	const WORK_PREREMOVE = 'jlm_daily.work_preremove';
	const SHIFTTECHNICIAN_POSTPERSIST  = 'jlm_daily.shifttechnician_postpersist';
	const SHIFTTECHNICIAN_POSTREMOVE  = 'jlm_daily.shifttechnician_postremove';
}