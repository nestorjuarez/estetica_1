
let eventGuid = 0
let todayStr = new Date().toISOString().replace(/T.*$/, '') // YYYY-MM-DD of today

export const INITIAL_EVENTS = [
  {
    id: createEventId(),
    title: 'All-day event',
    start: todayStr
  },
  {
    id: createEventId(),
    title: 'Timed event',
    start: '2020-06-26 16:00:00'
    // todayStr + 'T12:00:00'
  }
]

export function createEventId() {
  return String(eventGuid++)
}